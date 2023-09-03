<?php namespace App\Events\Potentials;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PotentialWasAccepted {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Potential that was activated.
     * @var User
     */
    public $user;

    /**
     * Instantiate PotentialWasAccepted event.
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}