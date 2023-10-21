<?php

namespace App\Jobs;

use App\Events\Members\AddressWasChanged;
use GSVnet\Users\Profiles\ProfilesRepository;

class ChangeAddress extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->address = $this->data['address'];
        $this->member->profile->zip_code = $this->data['zip_code'];
        $this->member->profile->town = $this->data['town'];
        $this->member->profile->country = $this->data['country'];

        $profiles->save($this->member->profile);

        AddressWasChanged::dispatch($this->member, $this->manager);
    }
}
