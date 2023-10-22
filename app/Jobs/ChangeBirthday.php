<?php

namespace App\Jobs;

use App\Events\Members\BirthdayWasChanged;
use Carbon\Carbon;
use GSVnet\Users\Profiles\ProfilesRepository;

class ChangeBirthday extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        // TODO: Constrain the parser based on what it receives from the HTML form.
        $this->member->profile->birthday = Carbon::parse($this->data["birthday"]);

        BirthdayWasChanged::dispatch($this->member, $this->manager);
    }
}
