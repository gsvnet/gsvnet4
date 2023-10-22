<?php

namespace App\Jobs;

use App\Events\Members\ParentDetailsWereChanged;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeParentsDetails extends ChangeProfileDetail
{
    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->parent_address = $this->data["parent_address"];
        $this->member->profile->parent_zip_code = $this->data["parent_zip_code"];
        $this->member->profile->parent_town = $this->data["parent_town"];
        $this->member->profile->parent_phone = $this->data["parent_phone"];
        $this->member->profile->parent_email = $this->data["parent_email"];

        $profiles->save($this->member->profile);

        ParentDetailsWereChanged::dispatch($this->member, $this->manager);
    }
}
