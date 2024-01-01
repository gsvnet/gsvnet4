<?php namespace GSV\Events\Forum;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReplyWasDeleted {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public mixed $threadId, 
        public mixed $replyId
    ) {}
}