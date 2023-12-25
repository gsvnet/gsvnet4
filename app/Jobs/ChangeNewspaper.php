<?php

namespace App\Jobs;

use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeNewspaper extends ChangeProfileDetail
{

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private bool $receive_newspaper
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch
    {
        $receive_newspaper = !! $request->get('receive_newspaper');

        return new PendingDispatch(new static($member, $request->user(), $receive_newspaper));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;
        $profile->receive_newspaper = $this->receive_newspaper;
        $profiles->save($profile);
    }
}
