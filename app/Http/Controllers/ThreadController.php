<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Jobs\DeleteThread;
use App\Jobs\StartThread;
use App\Jobs\UpdateThread;
use App\Jobs\VisitThread;
use App\Models\Thread;
use GSVnet\Events\EventsRepository;
use GSVnet\Forum\Replies\ReplyRepository;
use GSVnet\Forum\Threads\ThreadRepository;
use GSVnet\Forum\Threads\ThreadSearch;
use GSVnet\Forum\Threads\ThreadSlug;
use GSVnet\Forum\VisibilityLevel;
use GSVnet\Permissions\NoPermissionException;
use GSVnet\Tags\TagRepository;
use GSVnet\Users\UsersRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class ThreadController extends Controller
{
    private int $threadsPerPage = 50;
    private int $repliesPerPage = 20;

    public function __construct(
        private ThreadRepository $threads,
        private ReplyRepository $replies,
        private TagRepository $tags,
        private UsersRepository $users,
        private ThreadSearch $threadSearch,
        EventsRepository $events
    ) {
        // Make upcoming events available to all views returned by this controller.
        View::share('events', $events->upcoming(5));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // query tags and retrieve the appropriate threads
        $tags = $this->tags->getAllTagsBySlug($request->input('tags'));
        $threads = $this->threads->getByTagsPaginated($tags, $this->threadsPerPage);

        // add the tag string to each pagination link
        $tagAppends = ['tags' => $request->input('tags')];
        $queryString = !empty($tagAppends['tags']) ? '?tags=' . implode(',', (array)$tagAppends['tags']) : '';
        $threads->appends($tagAppends);

        return view('forum.threads.index', compact('threads', 'tags', 'queryString'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = $this->tags->getAllForForum();

        if( Auth::check() && Auth::user()->approved ) 
            $author = Auth::user();

        return view('forum.threads.create', compact('tags', 'author'));
    }

    /**
     * Return the visibility level unaltered if the user can view it, or the most restrictive alternative.
     */
    private function getAllowedVisibility(VisibilityLevel $visibility): VisibilityLevel
    {
        // No access to private? Bump visibility to internal.
        if ($visibility == VisibilityLevel::PRIVATE && Gate::denies('threads.show-private'))
            $visibility = VisibilityLevel::INTERNAL;

        // No access to internal? Bump visibility to public.
        if ($visibility == VisibilityLevel::INTERNAL && Gate::denies('threads.show-internal'))
            $visibility = VisibilityLevel::PUBLIC;

        return $visibility;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StartThreadRequest $request)
    {
        $subject = $request->get('subject');
        $slug = ThreadSlug::generate($subject);
        $visibility = $request->enum('visibility', VisibilityLevel::class);

        $visibility = $this->getAllowedVisibility($visibility);

        // Create thread and save the body as its first reply
        StartThread::dispatch(
            Auth::user()->id,
            $request->get('body'),
            $visibility,
            $this->tags->getTagsByIds($request->get('tags')),
            $subject,
            $slug
        );

        return redirect()->action([ThreadController::class, 'show'], [$slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $threadSlug)
    {
        $thread = $this->threads->getBySlug($threadSlug);

        if ( ! $thread)
            return redirect()->action([ThreadController::class, 'getIndex']);

        if ($thread->visibility == VisibilityLevel::PRIVATE && Gate::denies('threads.show-private'))
            throw new NoPermissionException;

        if ($thread->visibility == VisibilityLevel::INTERNAL && Gate::denies('threads.show-internal'))
            throw new NoPermissionException;

        $replies = $this->threads->getThreadRepliesPaginated($thread, $this->repliesPerPage);

        if( Auth::check() )
        {
            $user = Auth::user();

            // This is the author of any reply to be written,
            // not the author of the current thread.
            if (Auth::user()->approved)
               $author = $user;

            // Create or update visitation
            VisitThread::dispatch($user->id, $thread->id);
        }

        return view('forum.threads.show', compact('thread', 'replies', 'author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        $this->authorize('thread.manage', $thread);

        $author = $thread->author;

        $tags = $this->tags->getAllForForum();

        $visibility = $thread->visibility;

        return view('forum.threads.edit', compact('thread', 'tags', 'author', 'visibility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        $visibility = $request->enum('visibility', VisibilityLevel::class);

        $visibility = $this->getAllowedVisibility($visibility);

        UpdateThread::dispatch(
            $thread,
            $request->get('subject'),
            $this->tags->getTagsByIds($request->get('tags')),
            $visibility
        );

        return redirect()->action([ThreadController::class, 'show'], [$thread->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        $this->authorize('thread.manage', $thread);

        DeleteThread::dispatch($thread);

        return redirect()->action([ThreadController::class, 'index']);
    }

    /**
     * Show all threads that match a search query.
     */
    public function getSearch(Request $request)
    {
        // Search string
        $query = $request->input('query');

        // Include replies? Boolean
        $replies = $request->input('replies');
        
        $results = $this->threadSearch->searchPaginated($query, $replies, $this->threadsPerPage);
        $results->appends(['query' => $query]);

        return view('forum.search', compact('query', 'results'));
    }

    /**
     * Get forum user statistics.
     */
    public function statistics()
    {
        $perMonthUsers = $this->users->mostPostsPreviousMonth();
        $perWeekUsers = $this->users->mostPostsPreviousWeek();
        $allTimeUsers = $this->users->mostPostsAllTime();
        $allTimeUser = $this->users->postsAllTimeUser(Auth::user()->id);
        $allTimeUserRank = $this->users->postsAllTimeUserRank($allTimeUser);
        $likesGiven = $this->threads->totalLikesGivenPerYearGroup();
        $likesReceived = $this->threads->totalLikesReceivedPerYearGroup();

        return view('forum.stats', compact(
            'perMonthUsers',
            'perWeekUsers',
            'allTimeUsers',
            'likesGiven',
            'likesReceived',
            'allTimeUser',
            'allTimeUserRank'
        ));
    }

    /**
     * Display a listing of soft-deleted threads.
     */
    public function indexTrashed()
    {
        $this->authorize('thread.manage');

        $threads = $this->threads->getTrashedPaginated();

        return view('forum.threads.thrashed', compact('threads'));
    }
}
