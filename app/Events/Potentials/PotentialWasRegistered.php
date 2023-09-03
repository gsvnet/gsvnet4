<?php namespace App\Events\Potentials;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PotentialWasRegistered {

    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Potential that signed up.
     * @var User
     */
    public $user;

    /**
     * Additional comments the potential might have left.
     * @var string
     */
    public $message;

    /**
     * Secondary school that the potential visited.
     * @var string
     */
    public $school;

    /**
     * Year in which their study starts.
     * @var int
     */
    public $startYear;

    /**
     * Email address of their parents
     * @var string
     */
    public $parentsEmail;

    /**
     * Instantiate PotentialWasRegistered event.
     * @param \App\Models\User $user
     * @param string $message
     * @param string $school
     * @param int $startYear
     * @param string $parentsEmail
     */
    public function __construct(User $user, $message, $school, $startYear, $parentsEmail)
    {
        $this->user = $user;
        $this->message = $message;
        $this->school = $school;
        $this->startYear = $startYear;
        $this->parentsEmail = $parentsEmail;
    }
}