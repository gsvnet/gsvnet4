<?php namespace App\Handlers\Users;

// Events
use App\Events\Members\AddressWasChanged;
use App\Events\Members\BirthDayWasChanged;
use App\Events\Members\BusinessWasChanged;
use App\Events\Members\GenderWasChanged;
use App\Events\Members\MemberEmailWasChanged;
use App\Events\Members\MemberFileWasCreated;
use App\Events\Members\MembershipStatusWasChanged;
use App\Events\Members\NameWasChanged;
use App\Events\Members\ParentDetailsWereChanged;
use App\Events\Members\PeriodOfMembershipWasChanged;
use App\Events\Members\PhoneNumberWasChanged;
use App\Events\Members\ProfilePictureWasChanged;
use App\Events\Members\RegionWasChanged;
use App\Events\Members\StudyWasChanged;
use App\Events\Members\Verifications\EmailWasVerified;
use App\Events\Members\Verifications\FamilyWasVerified;
use App\Events\Members\Verifications\GenderWasVerified;
use App\Events\Members\Verifications\NameWasVerified;
use App\Events\Members\Verifications\YearGroupWasVerified;
use App\Events\Members\YearGroupWasChanged;
use App\Events\Potentials\PotentialSignedUp;
use App\Events\Users\UserWasRegistered;

// Handlers
use App\Handlers\Users\UserMailer;
use App\Handlers\Users\PotentialMailer;
use App\Handlers\Users\ProfileUpdates;
use App\Handlers\AbactisInformer;

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