<?php

namespace App\Jobs;

use App\Events\Members\NameWasChanged;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;

class ChangeName extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(
        UsersRepository $users,
        ProfilesRepository $profiles
    ): void
    {
        $this->member->profile->initials = $this->data['initials'];
        $this->member->firstname = $this->data['firstname'];
        $this->member->middlename = $this->data['middlename'];
        $this->member->lastname = $this->data['lastname'];

        $users->save($this->member);
        $profiles->save($this->member->profile);

        NameWasChanged::dispatch($this->member, $this->manager);
    }
}
