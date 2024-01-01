<?php namespace GSV\Handlers\Events\Forum;


use App\Events\Forum\ThreadWasRepliedTo;
use GSV\Events\Forum\ReplyWasDeleted;
use GSVnet\Forum\Threads\ThreadRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateThreadDetails implements ShouldQueue {

    public function __construct(
        private ThreadRepository $threads
    ) {}

	public function incrementReplies(ThreadWasRepliedTo $event)
    {
        $this->threads->incrementReplies($event->thread->id);
    }

    public function setNewLastReply(ThreadWasRepliedTo $event)
    {
        $this->threads->setLastReply($event->thread->id, $event->reply->id);
	}

    public function decrementReplies(ReplyWasDeleted $event)
    {
        $this->threads->decrementReplies($event->threadId);
    }

    public function resetLastReply(ReplyWasDeleted $event)
    {
        $thread = $this->threads->requireById($event->threadId);

        if($thread->most_recent_reply_id == $event->replyId)
            $this->threads->resetLatestReplyFor($thread);
    }
}
