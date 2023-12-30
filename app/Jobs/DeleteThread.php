<?php

namespace App\Jobs;

use App\Models\Thread;
use GSVnet\Forum\Threads\ThreadRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Thread $thread
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ThreadRepository $threads): void
    {
        $threads->delete($this->thread);
    }
}
