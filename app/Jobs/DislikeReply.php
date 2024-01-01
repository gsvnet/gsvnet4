<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;
use GSV\Events\Forum\ReplyWasDisliked;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DislikeReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private Reply $reply
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ReplyRepository $replies): void
    {
        $replies->dislike($this->user, $this->reply);

        ReplyWasDisliked::dispatch($this->reply->id, $this->user->id);
    }
}
