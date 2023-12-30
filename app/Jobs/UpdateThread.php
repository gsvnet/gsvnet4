<?php

namespace App\Jobs;

use App\Models\Thread;
use GSVnet\Forum\Threads\ThreadRepository;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Thread $thread,
        private string $subject,
        private Collection $tags,
        private VisibilityLevel $visibility
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ThreadRepository $threads): void
    {
        $thread = $this->thread;

        $thread->subject = $this->subject;
        $thread->visibility = $this->visibility;

        // Determine whether nothing but the visibility has been changed.
        // If so, don't update timestamps, so the topic doesn't jump to the top.
        if(!array_diff_key($thread->getDirty(), ["visibility" => null]))
            $thread->timestamps = false;

        $threads->save($thread);
        $threads->setTags($thread, $this->tags);
    }
}
