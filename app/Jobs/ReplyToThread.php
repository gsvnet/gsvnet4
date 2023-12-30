<?php

namespace App\Jobs;

use App\Events\ThreadWasRepliedTo;
use GSVnet\Forum\Replies\ReplyRepository;
use GSVnet\Forum\Threads\ThreadRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ReplyToThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $threadSlug,
        private mixed $authorId,
        private string $body
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ThreadRepository $threads, ReplyRepository $replies): void
    {
        $thread = $threads->requireBySlug($this->threadSlug);

        $reply = $replies->getNew([
            'thread_id' => $thread->id,
            'author_id' => $this->authorId,
            'body' => $this->body
        ]);

        $replies->save($reply);

        ThreadWasRepliedTo::dispatch($thread, $reply);
    }
}
