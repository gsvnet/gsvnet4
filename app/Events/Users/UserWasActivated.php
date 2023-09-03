<?php namespace App\Events\Users;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserWasActivated {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that was activated.
     * @var User
     */
    public $user;

    function __construct(User $user)
    {
        $this->user = $user;
    }
}