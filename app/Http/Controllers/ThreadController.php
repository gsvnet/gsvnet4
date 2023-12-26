<?php

namespace App\Http\Controllers;

use App\Http\Requests\StartThreadRequest;
use App\Jobs\StartThread;
use App\Jobs\VisitThread;
use GSVnet\Events\EventsRepository;
use GSVnet\Forum\Replies\ReplyRepository;
use GSVnet\Forum\Threads\ThreadRepository;
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

        if( Auth::check() ) {
           if (Auth::user()->approved)
               $author = Auth::user();
        }

        return view('forum.threads.create', compact('tags', 'author'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StartThreadRequest $request)
    {
        $subject = $request->get('subject');
        $slug = ThreadSlug::generate($subject);
        $visibility = $request->enum('visibility', VisibilityLevel::class);

        if ($visibility != VisibilityLevel::PUBLIC && Gate::denies('threads.show-internal'))
            $visibility = VisibilityLevel::PUBLIC;
        elseif ($visibility == VisibilityLevel::PRIVATE && Gate::denies('threads.show-private'))
            $visibility = VisibilityLevel::INTERNAL;

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

        if ( ! $thread->visibility == VisibilityLevel::PUBLIC && Gate::denies('threads.show-internal'))
            throw new NoPermissionException;

        if ($thread->visibility == VisibilityLevel::PRIVATE && Gate::denies('threads.show-private'))
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
