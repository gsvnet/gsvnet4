<?php

namespace App\Jobs;

use App\Events\Members\BirthdayWasChanged;
use App\Models\User;
use Carbon\Carbon;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeBirthday extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Carbon $birthday
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        // TODO: Constrain the parser based on what it receives from the HTML form.
        $birthday = Carbon::parse($request->get("birthday"));

        return new PendingDispatch(new static($member, $request->user(), $birthday));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->birthday = $this->birthday;
        $profiles->save($this->member->profile);

        BirthdayWasChanged::dispatch($this->member, $this->manager);
    }
}
