<?php

namespace App\Jobs;

use App\Http\Requests\StoreEventRequest;
use GSVnet\Events\EventsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $input;

    /**
     * Create a new job instance.
     */
    public function __construct(
        StoreEventRequest $request
    ) {
        $this->input = $request->validated();
        $this->input['location'] = $request->get('location', '');
        $this->input['whole_day'] = $request->get('whole_day', false);
        $this->input['public'] = $request->get('public', false) == 1;
        $this->input['published'] = $request->get('published', false) == 1;
    }

    /**
     * Execute the job.
     */
    public function handle(EventsRepository $events): void
    {   
        $events->create($this->input);
    }
}
