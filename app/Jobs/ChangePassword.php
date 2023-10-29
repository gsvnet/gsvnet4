<?php

namespace App\Jobs;

use App\Events\Users\PasswordWasSet;
use App\Models\User;
use GSVnet\Users\UsersRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private string $password
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $password = $request->input("password");

        return new PendingDispatch(new static($member, $request->user(), $password));
    }

    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $this->member->password = Hash::make($this->password);

        $users->save($this->member);
    }
}
