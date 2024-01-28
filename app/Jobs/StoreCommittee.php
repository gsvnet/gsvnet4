<?php

namespace App\Jobs;

use App\Http\Requests\StoreCommitteeRequest;
use GSVnet\Committees\CommitteesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class StoreCommittee implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $input;

    /**
     * Create a new job instance.
     */
    public function __construct(StoreCommitteeRequest $request)
    {
        $this->input = $request->only('name', 'description');
        $this->input['public'] = $request->get('public', false);
        $this->input['unique_name'] = Str::slug($request->get('unique_name'));
    }

    /**
     * Execute the job.
     */
    public function handle(CommitteesRepository $committees): void
    {
        $committees->create($this->input);
    }
}
