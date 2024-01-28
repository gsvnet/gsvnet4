<?php

namespace App\Http\Controllers;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Events\EventsRepository;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\YearGroupRepository;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function __construct(
        private ProfilesRepository $profiles,
        private YearGroupRepository $yearGroups,
        private RegionsRepository $regions,
        private EventsRepository $events
    ) {}

    public function members(Request $request)
    {
        $search = $request->get('zoekwoord', '');
        $type = $request->enum('type', UserTypeEnum::class); // TODO: Ensure this is an array
        $region = $request->get('regio');
        $reunist = $request->get('reunist');
        $yearGroup = $request->get('jaarverband');

        // Search on region
        if (!$region || ! $this->regions->exists($region))
            $region = null;

        // Enable search on yeargroup
        if (!$yearGroup || ! $this->yearGroups->exists($yearGroup))
            $yearGroup = null;

        // Search for reunists?
        if($reunist == 'ja')
            $type = [$type, UserTypeEnum::REUNIST];
        else
            $type = [$type];

        // Search types
        if (!in_array(UserTypeEnum::MEMBER, $type) && !in_array(UserTypeEnum::REUNIST, $type))
            $type = [UserTypeEnum::MEMBER, UserTypeEnum::REUNIST];

        $profiles = $this->profiles->searchLimit($search, $region, $yearGroup, $type, 30);

        $formatted = $profiles->map(function($profile){
            return [
                'id' => $profile->user->id,
                'fullName' => $profile->user->present()->fullName,
                'yearGroup' => $profile->yearGroup ? $profile->yearGroup->present()->nameWithYear : ''
            ];
        });

        return response()->json($formatted);
    }

    public function events() {
        $events = $this->events->upcoming();

        $formatted = $events->map(function($event) {
            return [
                'title' => $event->title,
                'description' => $event->meta_description,
                'start_date' => $event->start_date,
                'start_time' => $event->start_time,
                'end_date' => $event->end_date,
                'type' => $event->type
            ];
        });
        
        return response()->json($formatted);
    }
}