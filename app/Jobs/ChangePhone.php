<?php

namespace App\Jobs;

use App\Events\Members\PhoneNumberWasChanged;
use App\Jobs\ChangeProfileDetail;
use GSVnet\Users\Profiles\ProfilesRepository;

class ChangePhone extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->phone = $this->data["phone"];

        $profiles->save($this->member->profile);

        PhoneNumberWasChanged::dispatch($this->member, $this->manager);
    }
}
