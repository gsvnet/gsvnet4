<?php namespace App\Handlers\Users;

use App\Commands\Users\ChangePassword;
use GSVnet\Users\UsersRepository;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePasswordHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $password;
    private $user;

    public function __construct($password, User $user){
        $this->password = $password;
        $this->user = $user;
    }

    public function handle(UsersRepository $users)
    {
        $command = ChangePassword::fromForm($this->password, $this->user);
        $command->user->password = $command->password->getEncryptedPassword();
        $users->save($command->user);
    }
}