<?php

namespace App\Jobs;

use App\Http\Requests\StoreSenateRequest;
use GSVnet\Senates\SenatesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreSenate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $input;

    /**
     * Create a new job instance.
     */
    public function __construct(StoreSenateRequest $request) 
    {
        $this->input = $request->validated();
        $this->input['body'] = $request->get('body');
    }

    /**
     * Execute the job.
     */
    public function handle(SenatesRepository $senates): void
    {
        $senates->create($this->input);
    }
}
