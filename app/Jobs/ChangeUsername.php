<?php

namespace App\Jobs;

use GSVnet\Users\UsersRepository;

class ChangeUsername extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $this->member->username = $this->data['username'];

        $users->save($this->member);
    }
}
