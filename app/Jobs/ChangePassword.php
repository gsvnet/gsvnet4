<?php

namespace App\Jobs;

use App\Events\Users\PasswordWasSet;
use GSVnet\Users\UsersRepository;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $this->member->password = Hash::make($this->data["password"]);

        $users->save($this->member);
    }
}
