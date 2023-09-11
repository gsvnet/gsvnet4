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
use App\Events\Potentials\PotentialWasAccepted;
use App\Events\Potentials\PotentialWasRegistered;
use App\Events\Users\UserWasActivated;
use App\Events\Users\UserWasRegistered;

// Handlers
use App\Handlers\Users\UserMailer;
use App\Handlers\Potentials\PotentialMailer;
use App\Handlers\Members\ProfileUpdateSaver;
use App\Handlers\Admin\AbactisInformer;
use App\Handlers\Admin\NewsletterInformer;

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

    // TODO: Test all of these couplings

    public function subscribe(Dispatcher $events)
    {
        $events->listen(UserWasRegistered::class, [UserMailer::class, 'sendWelcomeEmail']);
        $events->listen(UserWasRegistered::class, [UserMailer::class, 'notifyReunist']);
        $events->listen(UserWasActivated::class, [UserMailer::class, 'sendActivatedEmail']);
        $events->listen(PotentialWasRegistered::class, [PotentialMailer::class, 'sendWelcomeEmail']);
        // Not sure if the line below ever gets called, in GSVnet3 this event was never fired
        $events->listen(PotentialWasAccepted::class, [PotentialMailer::class, 'sendActivatedEmail']);

        $events->listen(self::$profileChanges, [ProfileUpdateSaver::class, 'changedProfile']);
        $events->listen(self::$verifyAccountWhen, [ProfileUpdateSaver::class, 'tookAccountInUse']);

        $events->listen(MemberFileWasCreated::class, AbactisInformer::class);
        
        $events->listen(self::$informNewsletterFor, NewsletterInformer::class);

    }
}