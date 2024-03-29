<?php namespace GSV\Handlers\Events\Forum;

use GSV\Events\Forum\ReplyWasLiked;
use GSV\Events\Forum\ReplyWasDisliked;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateReplyDetails implements ShouldQueue {

    function __construct(
        private ReplyRepository $replies
    ) {}

    public function incrementLikes(ReplyWasLiked $event)
    {
        $this->replies->incrementLikeCount($event->replyId);
    }

    public function decrementLikes(ReplyWasDisliked $event)
    {
        $this->replies->decrementLikeCount($event->replyId);
    }
}