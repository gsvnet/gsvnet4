<?php

namespace App\Events\Forum;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadWasRepliedTo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Thread $thread,
        public Reply $reply
    ) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('activity'),
        ];
    }

    /**
     * The event's broadcast name.
     * 
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'app.reply';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
	        'user_id' => $this->reply->author_id,
            'username' => $this->reply->author->username,
            'subject' => $this->thread->subject
        ];
    }
}
