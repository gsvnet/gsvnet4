<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use GSVnet\Newsletters\NewsletterList;
use GSVnet\Users\ValueObjects\Address;
use GSVnet\Users\ValueObjects\Business;
use GSVnet\Users\ValueObjects\Email;
use GSVnet\Users\ValueObjects\Gender;
use GSVnet\Users\ValueObjects\Name;
use GSVnet\Users\ValueObjects\PhoneNumber;
use GSVnet\Users\ValueObjects\Study;
use GSVnet\Users\ValueObjects\Username;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ForgetMember implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $member,
        private User $manager,
        private bool $name,
        private bool $username,
        private bool $address,
        private bool $email,
        private bool $profilePicture,
        private bool $birthDay,
        private bool $gender,
        private bool $phone,
        private bool $study,
        private bool $business,
        private bool $parents
    ) {}

    static function dispatchFromForm(Request $request, User $member) {
        $self = new static(
            $member,
            $request->user(),
            $request->get('name'),
            $request->get('username'),
            $request->get('address'),
            $request->get('email'),
            $request->get('profilePicture'),
            $request->get('birthDay'),
            $request->get('gender'),
            $request->get('phone'),
            $request->get('study'),
            $request->get('business'),
            $request->get('parents')
        );

        return new PendingDispatch($self);
    }

    /**
     * Execute the job.
     */
    public function handle(NewsletterList $newsletterList): void
    {
        $member = $this->member;
        $manager = $this->manager;

        if ($this->name)
            ChangeName::dispatch($member, $manager, new Name("Onbekend", null, "Persoon", null));
        if ($this->username)
            ChangeUsername::dispatch($member, $manager, new Username(Str::random(15)));
        if ($this->address)
            ChangeAddress::dispatch($member, $manager, new Address(null, null, null, null));
        if ($this->email) {
            $newsletterList->unsubscribeFrom($member->type, $member->email);
            ChangeEmail::dispatch($member, $manager, new Email(Str::random(15)."@gsvnet.nl"));
        }
        if ($this->profilePicture)
            DeleteProfilePicture::dispatch($member, $manager);
        if ($this->birthDay)
            ChangeBirthDay::dispatch($member, $manager, Carbon::createFromDate(1966, 6, 23));
        if ($this->gender)
            ChangeGender::dispatch($member, $manager, new Gender(null));
        if ($this->phone)
            ChangePhone::dispatch($member, $manager, new PhoneNumber("+31600000000"));
        if ($this->study)
            ChangeStudy::dispatch($member, $manager, new Study(null, null));
        if ($this->business) 
            ChangeBusiness::dispatch($member, $manager, new Business(null, null, null));
        if ($this->parents) {
            ChangeParentsDetails::dispatch(
                $member,
                $manager,
                new Address(null, null, null),
                new PhoneNumber(null),
                new Email(null)
            );
        }
    }
}
