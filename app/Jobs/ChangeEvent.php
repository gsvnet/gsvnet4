<?php

namespace App\Jobs;

use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use GSVnet\Events\EventsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Event $event;
    private array $input;

    /**
     * Create a new job instance.
     */
    public function __construct(
        Event $event,
        UpdateEventRequest $request
    ) {
        $this->event = $event;

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
        $events->update($this->event->id, $this->input);
    }
}
