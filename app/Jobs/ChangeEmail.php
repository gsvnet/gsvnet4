<?php

namespace App\Jobs;

use App\Events\Members\MemberEmailWasChanged;
use App\Models\User;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\ValueObjects\Email;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeEmail extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Email $email
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $email = new Email(
            $request->get('email')
        );

        return new PendingDispatch(new static($member, $request->user(), $email));
    }

    /**
     * Execute the job.
     */
    public function handle(UsersRepository $users): void
    {
        $oldEmail = $this->member->email;
        $this->member->email = $this->email->getEmail();

        $users->save($this->member);

        MemberEmailWasChanged::dispatch($this->member, $this->manager, $oldEmail);
    }
}
