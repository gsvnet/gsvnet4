<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class ChangeProfileDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $manager;
    protected array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Request $request, 
        protected User $member // Promoted property
    ) {
        $this->manager = $request->user();
        $this->data = $request->all();
    }
}
