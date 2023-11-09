<?php

namespace App\Jobs;

use App\Events\Members\AddressWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\Address;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeAddress extends ChangeProfileDetail
{
    public function __construct(
        protected User $member,
        protected User $manager,
        private Address $address
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch
    {
        $address = new Address(
            $request->get('address'),
            $request->get('zip_code'),
            $request->get('town'),
            $request->get('country')
        );

        return new PendingDispatch(new static($member, $request->user(), $address));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;

        $profile->address = $this->address->getStreet();
        $profile->zip_code = $this->address->getZipCode();
        $profile->town = $this->address->getTown();
        $profile->country = $this->address->getCountry();
        $profiles->save($profile);

        AddressWasChanged::dispatch($this->member, $this->manager);
    }
}
