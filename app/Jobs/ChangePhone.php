<?php

namespace App\Jobs;

use App\Events\Members\PhoneNumberWasChanged;
use App\Jobs\ChangeProfileDetail;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\PhoneNumber;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangePhone extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private PhoneNumber $phoneNumber
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $phone = new PhoneNumber(
            $request->get('phone')
        );

        return new PendingDispatch(new static($member, $request->user(), $phone));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->phone = $this->phoneNumber->getPhone();

        $profiles->save($this->member->profile);

        PhoneNumberWasChanged::dispatch($this->member, $this->manager);
    }
}
