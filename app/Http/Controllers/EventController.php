<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GSVnet\Events\EventsRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventsRepository $events
    ) {}

    /**
     * Show a maximum of 10 upcoming events.
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {
        // Get all events which haven't finished yet
        $events = $this->events->upcoming(10);
        return view('events.index')
            ->with('searchTimeRange', false)
            ->with('events', $events)
            ->with('types', config('gsvnet.eventTypes'));
    }

    /**
     * Show all events in a given year or month.
     * 
     * @param int $year
     * @param string|null $strMonth
     * @return \Illuminate\Contracts\View\View
     */
    public function indexMonth(int $year, string $strMonth = null)
    {
        // Stores the month as number 01 ... 12
        $months = config('gsvnet.months');

        // Create $start and $end variables, which represent the time spans.
        if(is_null($strMonth))
        {
            $month = $months[$strMonth];
            $begin = $year . '-' . $month . '-01';
            // 't' gives number of days in the month. I.e., set $end to last day of month.
            $end = Carbon::createFromDate($year, $month, $day = 1)->format('Y-m-t');
        } else
        {
            $begin = $year . '-01-01';
            $end = $year . '-12-31';
        }

        // Select all events that take place between $start and $end
        $events = $this->events->between($begin, $end);

        // Make the view
        return view('events.index')
            ->with('events', $events)
            ->with('searchTimeRange', true)
            ->with('year', $year)
            ->with('month', $strMonth)
            ->with('types', config('gsvnet.eventTypes'));
    }

    /**
     * Show an event identified by year, month, and slug.
     * 
     * @param int $year
     * @param string $month
     * @param string $slug
     * @return \Illuminate\Contracts\View\View
     */
    public function show(int $year, string $month, string $slug)
    {
        $date = Carbon::createFromDate($year, config("gsvnet.months.$month"), 1);
        $event = $this->events->byYearMonthSlug($date, $slug);

        return view('events.show')
            ->with('event', $event)
            ->with('types', config('gsvnet.eventTypes'));
    }
}
