<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Reply; // Import the Reply model
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function create()
    {
        return view('Forum.create');
    }

    public function store(Request $request)
    {
        // Validate the form input
        $request->validate([
            'subject' => 'required|max:255', // Adjust the max length as needed
            'body' => 'required',
        ]);

        // Create a new thread
        $thread = new Thread;
        $thread->subject = $request->input('subject');
        $thread->body = $request->input('body');
        // You can add more fields as needed

        // Save the thread to the database
        $thread->save();

        // Redirect to the newly created thread
        // You can customize this based on your application's needs
        return redirect()->route('forum.show', ['id' => $thread->id]);
    }

    public function storeReply(Request $request, Thread $thread)
    {
        // Validate the reply input
        $request->validate([
            'body' => 'required',
        ]);

        // Create a new reply
        $reply = new Reply();
        $reply->body = $request->input('body');
        $reply->thread_id = $thread->id; // Associate the reply with the thread
        // You can add more fields as needed

        // Save the reply to the database
        $reply->save();

        // You may want to return a JSON response indicating success
        return response()->json(['message' => 'Reply created successfully']);
    }
}
