<?php

namespace App\Jobs;

use App\Events\Members\NameWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\ValueObjects\Name;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeName extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Name $name
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $name = new Name(
            $request->get('firstname'),
            $request->get('middlename'),
            $request->get('lastname'),
            $request->get('initials')
        );

        return new PendingDispatch(new static($member, $request->user(), $name));
    }

    /**
     * Execute the job.
     */
    public function handle(
        UsersRepository $users,
        ProfilesRepository $profiles
    ): void
    {
        $this->member->profile->initials = $this->name->getInitials();
        $this->member->firstname = $this->name->getFirstName();
        $this->member->middlename = $this->name->getMiddleName();
        $this->member->lastname = $this->name->getLastName();

        $users->save($this->member);
        $profiles->save($this->member->profile);

        NameWasChanged::dispatch($this->member, $this->manager);
    }
}
