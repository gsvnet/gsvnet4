<?php

namespace App\Jobs;

use App\Events\Members\RegionWasChanged;
use App\Models\Region;
use App\Models\User;
use GSVnet\Regions\RegionsRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeRegion extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private array $memberRegions
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $currentRegion = [ $request->get('current_region') ];
        $formerRegions = $request->get('former_regions') ? $request->get('former_regions') : [];

        $regions = app(RegionsRepository::class);
        $memberRegions = $regions->byIds(array_merge( $currentRegion, $formerRegions ));

        return new PendingDispatch(new static($member, $request->user(), $memberRegions));
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->member->profile->regions()->sync($this->memberRegions);

        RegionWasChanged::dispatch($this->member, $this->manager);
    }
}
