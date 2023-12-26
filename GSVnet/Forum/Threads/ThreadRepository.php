<?php namespace GSVnet\Forum\Threads;

use App\Models\Thread;
use GSVnet\Core\EloquentRepository;
use GSVnet\Core\Exceptions\EntityNotFoundException;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ThreadRepository extends EloquentRepository
{
    public function __construct(
        public Thread $model
    ) {}

    public function getIdBySlug($slug)
    {
        return $this->model->where('slug', '=', $slug)->pluck('id');
    }

    /**
     * Populate the likers attribute of the reply with the authenticated user IF they liked the reply.
     */
    private function addUserIfLiked(Builder $query): Builder
    {
        if( Auth::check() )
        {
            $id = Auth::user()->id;

            $query->with(['likers' => function(Builder $q) use ($id){
                $q->where('user_id', $id);
            }]);
        }

        return $query;
    }

    /**
     * Populate the visitations attribute of the thread with the authenticated user IF they visited the thread.
     */
    private function addUserIfVisited(Builder $query): Builder
    {
        if( Auth::check() )
        {
            $id = Auth::user()->id;

            $query->with(['visitations' => function(Builder $q) use ($id){
                $q->where('user_id', $id);
            }]);
        }

        return $query;
    }

    public function getByTagsPaginated(Collection $tags, $perPage = 20)
    {
        $query = $this->model->with(['mostRecentReply', 'mostRecentReply.author', 'tags']);

        if ($tags->count() > 0) {
            $query->join('tagged_items', 'forum_threads.id', '=', 'tagged_items.thread_id')
                ->whereIn('tagged_items.tag_id', $tags->pluck('id'));
        }

        if (Gate::denies('threads.show-internal'))
            $query = $query->where('visibility', VisibilityLevel::PUBLIC);
        elseif (Gate::denies('threads.show-private')) // Allows internal, but not private
            $query = $query->whereNot('visibility', VisibilityLevel::PRIVATE);

        $query = $this->addUserIfVisited($query);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    /**
     * Get replies to provided `$thread`, paginated.
     * 
     * Also provides every reply's author. If the authenticated user has liked the reply, the user will be provided to the reply's `likers` attribute. Otherwise, `likers` is empty.
     * 
     * @param Thread $thread
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getThreadRepliesPaginated(Thread $thread, $perPage = 20): LengthAwarePaginator
    {
        $query = $thread->replies()->with('author');

        $query = $this->addUserIfLiked($query);

        $query->orderBy('created_at', 'asc');

        return $query->paginate($perPage);
    }

    public function requireBySlug($slug)
    {
        $model = $this->getBySlug($slug);

        if ( ! $model) {
            throw new EntityNotFoundException;
        }

        return $model;
    }

    public function getBySlug($slug)
    {
        $query = $this->model->where('slug', '=', $slug);
        
        // Include removed ones if permissions allow
        if (Gate::allows('thread.manage'))
            $query->withTrashed();

        $query = $this->addUserIfLiked($query);

        return $query->first();
    }

    public function getTrashedPaginated($perPage = 20)
    {
        $query = $this->model->onlyTrashed()->with(['mostRecentReply', 'mostRecentReply.author', 'tags']);

        if ( Gate::denies('threads.show-internal'))
        {
            $query = $query->public();
        }

        if (Gate::denies('threads.show-private'))
            $query = $query->where('private', '=', 0);

        $query = $this->addUserIfVisited($query);

        $query->orderBy('updated_at', 'desc');

        return $query->paginate($perPage, ['forum_threads.*']);
    }

    public function setTags(Thread $thread, $tags)
    {
        $thread->tags()->sync($tags);
    }

    public function incrementReplies($threadId)
    {
        $this->model->where('id', $threadId)->increment('reply_count');
    }
    public function decrementReplies($threadId)
    {
        $this->model->where('id', $threadId)->decrement('reply_count');
    }

    public function setLastReply($threadId, $replyId)
    {
        $this->model->where('id', $threadId)->update([
            'most_recent_reply_id' => $replyId
        ]);
    }

    public function resetLatestReplyFor(Thread $thread)
    {
        $last = $thread->replies()->orderBy('created_at', 'DESC')->first();

        if(!$last)
            $thread->most_recent_reply_id = null;
        else
            $thread->most_recent_reply_id = $last->id;

        $thread->save();
    }

    public function slugExists($slug)
    {
        return $this->model::withTrashed()->where('slug', $slug)->exists();
    }

    // Note: We don't allow threads themselves to be liked anymore.

    public function totalLikesGivenPerYearGroup()
    {
        return Cache::remember('total-likes-given-per-year-group', 24*60, function()
        {
            return \DB::select("SELECT yg.name as name, count(1) AS likes_given
                FROM likes as l
                INNER JOIN user_profiles as up
                ON l.user_id = up.user_id
                INNER JOIN year_groups as yg
                ON yg.id = up.year_group_id
                GROUP BY yg.id
                HAVING likes_given > 30
                ORDER BY yg.year DESC"
            );
        });
    }

    public function totalLikesReceivedPerYearGroup()
    {
        return Cache::remember('total-likes-received-per-year-group', 24*60, function()
        {
            return \DB::select("SELECT yg.name, count(yg.id) AS likes_received
                FROM likes as l
                INNER JOIN forum_replies as fr
                ON fr.id = l.reply_id
                INNER JOIN user_profiles as up
                ON fr.author_id = up.user_id
                INNER JOIN year_groups as yg
                ON yg.id = up.year_group_id
                GROUP BY yg.id
                HAVING likes_received > 30
                ORDER BY yg.year DESC"
            );
        });
    }
}