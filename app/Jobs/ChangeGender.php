<?php

namespace App\Jobs;

use App\Events\Members\GenderWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\Gender;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeGender extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Gender $gender
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $gender = new Gender($request->input("gender"));

        return new PendingDispatch(new static($member, $request->user(), $gender));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->gender = $this->gender->getGender();

        $profiles->save($this->member->profile);

        GenderWasChanged::dispatch($this->member, $this->manager);
    }
}
