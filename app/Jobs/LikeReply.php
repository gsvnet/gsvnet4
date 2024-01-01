<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;
use GSV\Events\Forum\ReplyWasLiked;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LikeReply implements ShouldQueue
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
        $replies->like($this->user, $this->reply);

        ReplyWasLiked::dispatch($this->reply->id, $this->user->id);
    }
}
