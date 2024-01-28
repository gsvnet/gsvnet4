<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Jobs\ChangeEvent;
use App\Jobs\StoreEvent;
use App\Models\Event;
use GSVnet\Events\EventsRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventsRepository $events
    ) {
        $this->authorize('events.manage');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->events->paginate(50, false);

        return view('admin.events.index')
            ->with('events', $events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        StoreEvent::dispatch($request);

        $title = $request->get('title');

        session()->flash('success', "{$title} is succesvol opgeslagen.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show')
            ->with('event', $event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit')
            ->with('event', $event);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        ChangeEvent::dispatch($event, $request);

        session()->flash('success', "{$event->title} is succesvol bewerkt.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->events->delete($event->id);

        session()->flash('success', "{$event->title} is succesvol verwijderd.");

        return redirect()->action([$this::class, 'index']);
    }
}
