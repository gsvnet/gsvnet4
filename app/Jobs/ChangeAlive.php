<?php

namespace App\Jobs;

use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeAlive extends ChangeProfileDetail
{
    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private bool $alive
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $alive = (bool) $request->get('alive');

        return new PendingDispatch(new static($member, $request->user(), $alive));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;

        $profile->alive = $this->alive;

        $profiles->save($profile);
    }
}
