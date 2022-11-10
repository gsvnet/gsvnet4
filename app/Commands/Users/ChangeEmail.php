<?php namespace App\Commands\Users;

use Illuminate\Http\Request;
use App\Models\User;
use GSVnet\Users\ValueObjects\Email;
use Illuminate\Console\Command;

class ChangeEmail extends Command {

    public $user;

    public $manager;

    public $email;

    function __construct(User $user, User $manager, Email $email)
    {
        $this->email = $email;
        $this->user = $user;
        $this->manager = $manager;
    }

    static function fromForm($email, User $user, User $userReq)
    {
        $email = new Email($email);
        return new self($user, $userReq, $email);
    }
}