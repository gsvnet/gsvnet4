<?php namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserWasRegistered {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that was registered.
     * @var User
     */
    public $user;

    /**
     * Construct UserWasRegistered event
     * @param \App\Models\User $user
     */
    function __construct(User $user)
    {
        $this->user = $user;
    }
}