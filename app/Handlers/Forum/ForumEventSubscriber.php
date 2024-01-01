<?php namespace App\Handlers\Forum;

use App\Events\Forum\ThreadWasRepliedTo;
use GSV\Events\Forum\ReplyWasDeleted;
use GSV\Handlers\Events\Forum\UpdateThreadDetails;
use Illuminate\Events\Dispatcher;

class ForumEventSubscriber
{
    /**
     * Register listeners for forum events.
     */
    function subscribe(Dispatcher $events): void {
        $events->listen(ThreadWasRepliedTo::class, [UpdateThreadDetails::class, 'incrementReplies']);
        $events->listen(ThreadWasRepliedTo::class, [UpdateThreadDetails::class, 'setNewLastReply']);
    
        $events->listen(ReplyWasDeleted::class, [UpdateThreadDetails::class, 'decrementReplies']);
        $events->listen(ReplyWasDeleted::class, [UpdateThreadDetails::class, 'resetLastReply']);
    }
}