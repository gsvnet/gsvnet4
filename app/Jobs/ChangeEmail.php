<?php

namespace App\Jobs;

use App\Events\Members\MemberEmailWasChanged;
use GSVnet\Users\UsersRepository;

class ChangeEmail extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $oldEmail = $this->member->email;
        $this->member->email = $this->data["email"];

        $users->save($this->member);

        MemberEmailWasChanged::dispatch($this->member, $this->manager, $oldEmail);
    }
}
