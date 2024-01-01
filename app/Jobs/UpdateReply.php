<?php

namespace App\Jobs;

use App\Models\Reply;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Reply $reply,
        private string $body
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ReplyRepository $replies): void
    {
        $this->reply->body = $this->body;
        
        $replies->save($this->reply);
    }
}
