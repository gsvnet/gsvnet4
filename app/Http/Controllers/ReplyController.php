<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Jobs\ReplyToThread;
use GSVnet\Events\EventsRepository;
use GSVnet\Forum\Replies\ReplyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ReplyController extends Controller
{
    private int $repliesPerPage = 20;

    public function __construct(
        private ReplyRepository $replies, 
        EventsRepository $events
    ) {
        // Make upcoming events available to all views returned by this controller.
        View::share('events', $events->upcoming(5));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    //TODO: Create ThreadWasRepliedTo listeners

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReplyRequest $request, string $threadSlug)
    {
        ReplyToThread::dispatch(
            $threadSlug,
            Auth::user()->id,
            $request->get('body')
        );

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
