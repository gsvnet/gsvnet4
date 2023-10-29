<?php

namespace App\Jobs;

use App\Events\Members\ParentDetailsWereChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\Address;
use GSVnet\Users\ValueObjects\Email;
use GSVnet\Users\ValueObjects\PhoneNumber;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeParentsDetails extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Address $address,
        private PhoneNumber $phoneNumber,
        private Email $email
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $address = new Address(
            $request->input("parent_address"),
            $request->input("parent_zip_code"),
            $request->input("parent_town")
        );

        $phone = new PhoneNumber($request->input("parent_phone"));

        $email = new Email($request->input("email"));

        return new PendingDispatch(
            new static($member, $request->user(), $address, $phone, $email));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;

        $profile->parent_address = $this->address->getStreet();
        $profile->parent_zip_code = $this->address->getZipCode();
        $profile->parent_town = $this->address->getTown();
        $profile->parent_phone = $this->phoneNumber->getPhone();
        $profile->parent_email = $this->email->getEmail();

        $profiles->save($profile);

        ParentDetailsWereChanged::dispatch($this->member, $this->manager);
    }
}
