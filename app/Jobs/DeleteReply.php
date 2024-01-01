<?php

namespace App\Jobs;

use App\Models\Reply;
use GSV\Events\Forum\ReplyWasDeleted;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Reply $reply
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ReplyRepository $replies): void
    {
        $reply = $this->reply;

        $threadId = $reply->thread_id;
        $replyId = $reply->id;

        $replies->delete($reply);

        ReplyWasDeleted::dispatch($threadId, $replyId);
    }
}
