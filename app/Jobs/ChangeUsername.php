<?php

namespace App\Jobs;

use App\Models\User;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\ValueObjects\Username;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeUsername extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Username $username
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $username = new Username(
            $request->get('username')
        );

        return new PendingDispatch(new static($member, $request->user(), $username));
    }

    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $this->member->username = $this->username->getUsername();

        $users->save($this->member);
    }
}
