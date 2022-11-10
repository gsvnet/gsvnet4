<?php namespace App\Handlers\Users;

use GSVnet\Users\UsersRepository;
use App\Commands\Users\ChangeEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeEmailHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $request;
    private $user;
    private $email;

    public function __construct($email, User $user)
    {
        $this->user = $user;
        $this->email = $email;
    }

    public function handle(UsersRepository $users)
    {
        $command = ChangeEmail::fromForm($this->email, $this->user);
        $this->validateUniqueness($command);

        $command->user->email = $command->email->getEmail();
        $users->save($command->user);
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