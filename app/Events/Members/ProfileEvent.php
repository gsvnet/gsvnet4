<?php namespace App\Events\Members;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class ProfileEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var Carbon
     */
    protected $at;

    /**
     * @var User
     */
    protected $manager;

    /**
     * ProfileEvent constructor.
     * @param User $user
     * @param User $manager
     */
    public function __construct(User $user, User $manager)
    {
        $this->at = Carbon::now();
        $this->user = $user;
        $this->manager = $manager;
    }

    /**
     * @return Carbon
     */
    public function getAt()
    {
        return $this->at;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return User
     */
    public function getManager()
    {
        return $this->manager;
    }
}