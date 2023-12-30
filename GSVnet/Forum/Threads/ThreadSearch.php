<?php namespace GSVnet\Forum\Threads;

use App\Models\Thread;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use GSVnet\Forum\Replies\ReplySearch;

class ThreadSearch
{
    protected $model;

    public function __construct(Thread $model)
    {
        $this->model = $model;
    }

    // this stuff is just a placeholder until we implement
    // a real search system
    // Idea: Laravel Scout with Meilisearch
    public function searchPaginated(string $query, bool $replies, int $perPage): LengthAwarePaginator
    {
        $userId = Auth::check() ? Auth::user()->id : 0;
       
        if($replies) {
            $thread_ids = app(ReplySearch::class)->searchReplys($query);
        } else {
            $thread_ids = [];
        }
        
        $query = $this->model->where(function($q) use ($query, $thread_ids) {
            $q->where('subject', 'like', '%' . $query . '%')
                ->orWhereIn('id', $thread_ids);
            })
            ->orderBy('updated_at', 'desc')
            ->with(['mostRecentReply'])
            ->with(['visitations' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        
        if (Gate::denies('threads.show-private'))
            $query = $query->whereNot('visibility', '=', VisibilityLevel::PRIVATE);
        
        if (Gate::denies('threads.show-internal'))
            $query = $query->whereNot('visibility', '=', VisibilityLevel::INTERNAL);

        return $query->paginate($perPage, ['forum_threads.*']);
    }
}