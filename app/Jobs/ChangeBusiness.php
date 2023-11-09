<?php

namespace App\Jobs;

use App\Events\Members\BusinessWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\Business;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeBusiness extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Business $business
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $business = new Business(
            $request->get('company'),
            $request->get('profession'),
            $request->get('business_url')
        );

        return new PendingDispatch(new static($member, $request->user(), $business));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;
        $profile->company = $this->business->getCompany();
        $profile->profession = $this->business->getProfession();
        $profile->business_url = $this->business->getUrl();

        $profiles->save($profile);

        BusinessWasChanged::dispatch($this->member, $this->manager);
    }
}
