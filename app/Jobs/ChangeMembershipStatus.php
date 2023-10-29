<?php

namespace App\Jobs;

use App\Events\Members\MembershipStatusWasChanged;
use App\Models\User;
use App\Models\UserProfile;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeMembershipStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private UserTypeEnum $type,
        private User $member,
        private User $manager
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        UsersRepository $users,
        ProfilesRepository $profiles
    ): void
    {
        $old_type = $this->member->type;
        $this->member->type = $this->type;
        $users->save($this->member);

        /* Ensure the user has a profile if needed */
        if($this->member->wasOrIsMember() && !$this->member->profile) {
            // Set the property of the current object and save relationship to database
            $this->member->profile = new UserProfile();
            $this->member->profile()->save($this->member->profile);
        }

        // We don't need to keep parents' details of reunists.
        if ($this->member->isReunist()) {
            ForgetMember::dispatch(
                $this->member,
                $this->manager,
                false, // name
                false, // username
                false, // address
                false, // email
                false, // profilePicture
                false, // birthday
                false, // gender
                false, // phone
                false, // study
                false, // business
                true // parents
            );
        }

        // Remove even more user details when changing to ex-member.
        if($this->member->isExMember()) {
            ForgetMember::dispatch(
                $this->member,
                $this->manager,
                false, // name
                false, // username
                true, // address
                false, // email
                true, // profilePicture
                true, // birthday
                true, // gender
                true, // phone
                true, // study
                true, // business
                true // parents
            );
        }

        MembershipStatusWasChanged::dispatch($this->member, $this->manager, $old_type);
    }
}
