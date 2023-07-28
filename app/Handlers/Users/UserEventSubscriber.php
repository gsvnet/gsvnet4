<?php namespace App\Handlers\Users;

// Events
use GSV\Events\Members\AddressWasChanged;
use GSV\Events\Members\BirthDayWasChanged;
use GSV\Events\Members\BusinessWasChanged;
use GSV\Events\Members\GenderWasChanged;
use GSV\Events\Members\MemberEmailWasChanged;
use GSV\Events\Members\MemberFileWasCreated;
use GSV\Events\Members\MembershipStatusWasChanged;
use GSV\Events\Members\NameWasChanged;
use GSV\Events\Members\ParentDetailsWereChanged;
use GSV\Events\Members\PeriodOfMembershipWasChanged;
use GSV\Events\Members\PhoneNumberWasChanged;
use GSV\Events\Members\ProfilePictureWasChanged;
use GSV\Events\Members\RegionWasChanged;
use GSV\Events\Members\StudyWasChanged;
use GSV\Events\Members\Verifications\EmailWasVerified;
use GSV\Events\Members\Verifications\FamilyWasVerified;
use GSV\Events\Members\Verifications\GenderWasVerified;
use GSV\Events\Members\Verifications\NameWasVerified;
use GSV\Events\Members\Verifications\YearGroupWasVerified;
use GSV\Events\Members\YearGroupWasChanged;
use GSV\Events\Potentials\PotentialSignedUp;
use GSV\Events\Users\UserWasRegistered;

// Handlers
use GSV\Handlers\Events\Users\UserMailer;
use GSV\Handlers\Events\Potentials\PotentialMailer;
use GSV\Handlers\Events\Members\ProfileUpdates;
use GSV\Handlers\Events\AbactisInformer;

use Illuminate\Events\Dispatcher;

class UserEventSubscriber
{
    static $profileChanges = [
        AddressWasChanged::class,
        BirthDayWasChanged::class,
        BusinessWasChanged::class,
        GenderWasChanged::class,
        MemberEmailWasChanged::class,
        NameWasChanged::class,
        ParentDetailsWereChanged::class,
        PeriodOfMembershipWasChanged::class,
        PhoneNumberWasChanged::class,
        ProfilePictureWasChanged::class,
        RegionWasChanged::class,
        StudyWasChanged::class,
        YearGroupWasChanged::class,
        MembershipStatusWasChanged::class,

        EmailWasVerified::class,
        GenderWasVerified::class,
        NameWasVerified::class,
        YearGroupWasVerified::class,
        FamilyWasVerified::class,
    ];

    static $informAbactisFor = [
        AddressWasChanged::class,
        BirthDayWasChanged::class,
        BusinessWasChanged::class,
        MemberEmailWasChanged::class,
        ParentDetailsWereChanged::class,
        PhoneNumberWasChanged::class,
        StudyWasChanged::class,
    ];

    static $informNewsletterFor = [
        NameWasChanged::class,
        MemberEmailWasChanged::class,
        GenderWasChanged::class,
        MembershipStatusWasChanged::class,
        YearGroupWasChanged::class,
    ];

    static $verifyAccountWhen = [
        MemberEmailWasChanged::class,
        EmailWasVerified::class
    ];

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserWasRegistered::class, [UserMailer::class, 'sendWelcomeEmail']);
        $events->listen(UserWasRegistered::class, [UserMailer::class, 'notifyReunist']);
        $events->listen(PotentialSignedUp::class, [PotentialMailer::class, 'sendWelcomeMail']);

        $events->listen(self::$profileChanges, [ProfileUpdates::class, 'changedProfile']);
        $events->listen(self::$verifyAccountWhen, [ProfileUpdates::class, 'tookAccountInUse']);

        // Disable this for now, since a lot of mails are coming in
        // $events->listen(self::$informAbactisFor, AbactisInformer::class);
        $events->listen(MemberFileWasCreated::class, [AbactisInformer::class, 'sendMemberFile']);
        
        $events->listen(self::$informNewsletterFor, NewsletterInformer::class);

        // TODO: Change these into proper handlers (no clue why we got two UserMailers)
        $events->listen('user.registered', 'GSVnet\Users\UserMailer@registered');
        $events->listen('user.activated', 'GSVnet\Users\UserMailer@activated');

        $events->listen('potential.registered', 'GSVnet\Users\UserMailer@membership');
        $events->listen('potential.accepted', 'GSVnet\Users\UserMailer@membershipAccepted');

    }
}