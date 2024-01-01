<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Http\Requests\UpdateReplyRequest;
use App\Jobs\DeleteReply;
use App\Jobs\ReplyToThread;
use App\Jobs\UpdateReply;
use App\Models\Reply;
use GSVnet\Events\EventsRepository;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ReplyController extends Controller
{
    private int $repliesPerPage = 20;

    public function __construct(
        private ReplyRepository $replies, 
        EventsRepository $events
    ) {
        // Make upcoming events available to all views returned by this controller.
        View::share('events', $events->upcoming(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReplyRequest $request, string $threadSlug)
    {
        ReplyToThread::dispatch(
            $threadSlug,
            Auth::user()->id,
            $request->get('body')
        );

        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reply $reply)
    {
        $this->authorize('reply.manage', $reply);

        $author = $reply->author;

        return view('forum.replies.edit', compact('reply', 'author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReplyRequest $request, Reply $reply)
    {
        UpdateReply::dispatch(
            $reply,
            $request->get('body')
        );

        return $this->redirectToReply($reply);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('reply.manage', $reply);

        DeleteReply::dispatch($reply);

        return redirect('/forum');
    }

    private function redirectToReply(Reply $reply): RedirectResponse
    {
        $page = $reply->thread->getReplyPageNumber($reply->id, $this->repliesPerPage);

        return redirect()->action(
            [ThreadController::class, 'show'], 
            [
                $reply->thread->slug,
                "page=" . $page . "#reactie-" . $reply->id
            ]
        );
    }
}
