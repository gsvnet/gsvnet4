<?php

namespace App\Jobs;

use App\Events\Members\PeriodOfMembershipWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\MembershipPeriod;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeMembershipPeriod extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private MembershipPeriod $membershipPeriod
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $period = new MembershipPeriod(
            $request->get("inauguration_date"), 
            $request->get("resignation_date")
        );

        return new PendingDispatch(new static($member, $request->user(), $period));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;
        $profile->inauguration_date = $this->membershipPeriod->getInaugurationDate();
        $profile->resignation_date = $this->membershipPeriod->getresignationDate();

        $profiles->save($profile);

        PeriodOfMembershipWasChanged::dispatch($this->member, $this->manager);
    }
}
