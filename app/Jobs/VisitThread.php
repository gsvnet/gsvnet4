<?php

namespace App\Jobs;

use App\Models\ThreadVisitation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VisitThread implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $userId,
        private $threadId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $visitation = ThreadVisitation::firstOrNew([
            'user_id' => $this->userId,
            'thread_id' => $this->threadId
        ]);

        $visitation->visited_at = date('Y-m-d H:i:s');

        $visitation->save();
    }
}
