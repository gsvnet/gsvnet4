<?php namespace App\Commands\Users;

use App\Models\User;
use GSVnet\Users\ValueObjects\PasswordDef;
use Illuminate\Http\Request;
use Illuminate\Console\Command;

class ChangePassword extends Command {
   
    public $user;
    public $password;

    public function __construct(User $user, PasswordDef $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public static function fromForm($password, User $user)
    {
        $password = new PasswordDef($password);
        return new static($user, $password);
    }
}