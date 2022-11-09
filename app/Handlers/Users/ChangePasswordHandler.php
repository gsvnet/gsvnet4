<?php namespace App\Handlers\Users;

use App\Commands\Users\ChangePassword;
use GSVnet\Users\UsersRepository;

class ChangePasswordHandler {

    private $users;

    public function __construct(UsersRepository $users){
        $this->users = $users;
    }

    public function handle(ChangePassword $command)
    {
        $command->user->password = $command->password->getEncryptedPassword();
        $this->users->save($command->user);
    }
}