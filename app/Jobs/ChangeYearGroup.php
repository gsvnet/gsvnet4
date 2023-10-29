<?php

namespace App\Jobs;

use App\Events\Members\YearGroupWasChanged;
use App\Models\User;
use App\Models\YearGroup;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\YearGroupRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeYearGroup extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private YearGroup $yearGroup
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $yearGroups = app(YearGroupRepository::class);
        $group = $yearGroups->byId($request->get('year_group_id'));

        return new PendingDispatch(new static($member, $request->user(), $group));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->member->profile->yearGroup()->associate($this->yearGroup);

        $profiles->save($this->member->profile);

        YearGroupWasChanged::dispatch($this->member, $this->manager);
    }
}
