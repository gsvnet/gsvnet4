<?php

namespace App\Jobs;

use App\Http\Requests\StoreSenateRequest;
use App\Models\Senate;
use GSVnet\Senates\SenatesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeSenate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Senate $senate;
    private array $input;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Senate $senate, 
        StoreSenateRequest $request
    ) {
        $this->senate = $senate;

        $this->input = $request->validated();
        $this->input['body'] = $request->get('body');
    }

    /**
     * Execute the job.
     */
    public function handle(SenatesRepository $senates): void
    {
        $senates->update($this->senate->id, $this->input);
    }
}
