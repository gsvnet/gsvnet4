<?php

namespace App\Jobs;

use GSVnet\Forum\Replies\ReplyRepository;
use GSVnet\Forum\Threads\ThreadRepository;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $authorId,
        private string $body,
        private VisibilityLevel $visibility,
        private Collection $tags,
        private string $subject,
        private string $slug
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ThreadRepository $threads, ReplyRepository $replies): void
    {
        // Create thread, don't save it yet
        $thread = $threads->getNew([
            'subject' => $this->subject,
            'author_id' => $this->authorId,
            'visibility' => $this->visibility,
            'slug' => $this->slug,
            'reply_count' => 1,
            'most_recent_reply_id' => null
        ]);

        // Body of the thread will be incorporated in its first reply
        $reply = $replies->getNew([
            'thread_id' => $thread->id,
            'author_id' => $this->authorId,
            'body' => $this->body
        ]);

        $replies->save($reply);

        // After adding the reply id to the thread entry, we can save it and sync the tags
        $thread->most_recent_reply_id = $reply->id;

        $threads->save($thread);
        $threads->setTags($thread, $this->tags);

        // Note: It seems unnecessary to fire an event for the reply specifically, 
        // because we can do all necessary thread modifications right above, during thread creation. 
        // If we want to fire an event, then the only event that really needs to be fired is 
        // the one that indicates that a thread has been created.
    }
}
