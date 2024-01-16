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

    static function dispatchFromArray(User $member, User $manager, array $data): PendingDispatch 
    {
        $address = new Address(
            $data["parent_address"],
            $data["parent_zip_code"],
            $data["parent_town"]
        );

        $phone = new PhoneNumber($data["parent_phone"]);

        $email = new Email($data["parent_email"]);

        return new PendingDispatch(
            new static($member, $manager, $address, $phone, $email));
    }

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $data = $request->only([
            "parent_address", "parent_zip_code", "parent_town",
            "parent_phone", "parent_email"
        ]);

        return self::dispatchFromArray($member, $request->user(), $data);
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
