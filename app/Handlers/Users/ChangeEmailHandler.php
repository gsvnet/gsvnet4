<?php namespace App\Handlers\Users;

use GSVnet\Users\UsersRepository;
use App\Commands\Users\ChangeEmail;


class ChangeEmailHandler
{
    private $users;

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function handle(ChangeEmail $command)
    {
        $this->validateUniqueness($command);

       // $oldEmail = $command->user->email; Could be used for something like info report

        $command->user->email = $command->email->getEmail();
        $this->users->save($command->user);
    }

    private function validateUniqueness(ChangeEmail $command)
    {
        //TODO: Create validationException
     //   if ($this->users->isEmailAddressTaken($command->email->getEmail(), $command->user->id)) {
     //       throw new ValidationException(new MessageBag([
     //           'email' => 'Emailadres al bezet'
     //       ]));
     //   }
    }
}