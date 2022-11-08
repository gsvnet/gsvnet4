<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

use GSVnet\Users\UsersRepository;
use GSVnet\Committees\CommitteesRepository;
use GSVnet\Regions\RegionsRepository;
use Illuminate\Support\Facades\Log;

//Work in progress, can't be extended since authentication is required
class UserController extends Controller
{
    protected $users;
    protected $committees;
    protected $regions;

    public function __construct(
        UsersRepository $users,
        CommitteesRepository $committees,
        RegionsRepository $regions
    ) {
        $this->users = $users;
        $this->committees = $committees;
        $this->regions = $regions;
    }


    public function showProfile()
    {
        $id = Auth::id();
        $member = $this->users->byId($id);
        $committees = $this->committees->byUserOrderByRecent($member);
        $senates = $member->senates;

        $formerRegions = [];
        if($member->profile && $member->profile->regions) {
            $formerRegions =  $member->profile->regions->intersect($this->regions->former());
        }

        return view('userprofile', [
            'user' => $member,
            'committees' => $committees,
            'senates' => $senates,
            'formerRegions' => $formerRegions
        ]);
    }
}
