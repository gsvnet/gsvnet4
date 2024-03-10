<?php namespace App\Http\Controllers;

use App\Http\Requests\UpdatePartialProfileRequest;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\ChangeEmail;
use App\Jobs\ChangePassword;
use GSVnet\Users\UsersRepository;
use GSVnet\Committees\CommitteesRepository;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\YearGroupRepository;
use GSVnet\Users\Profiles\ProfilesRepository;

class UserController extends Controller
{
    protected $users;
    protected $committees;
    protected $regions;
    protected $yearGroups;
    protected $profiles;

    public function __construct(
        UsersRepository $users,
        CommitteesRepository $committees,
        RegionsRepository $regions,
        YearGroupRepository $yearGroups,
        ProfilesRepository $profiles
    ) {
        $this->users = $users;
        $this->committees = $committees;
        $this->regions = $regions;
        $this->yearGroups = $yearGroups;
        $this->profiles = $profiles;
    }


    public function showProfile(Request $request, User $user)
    {
        $committees = $this->committees->byUserOrderByRecent($user);
        $senates = $user->senates;

        $formerRegions = [];
        if($user->profile && $user->profile->regions) {
            $formerRegions =  $user->profile->regions->intersect($this->regions->former());
        }

        return view('users.user-profile', [
            'user' => $user,
            'committees' => $committees,
            'senates' => $senates,
            'formerRegions' => $formerRegions
        ]);
    }

    public function editProfile(Request $request)
    {
        return view('users.user-edit', [
            'user' => $request->user()
        ]);
    }

    public function updateProfile(UpdatePartialProfileRequest $request)
    {
        $user = $request->user();

        if ($user->email != $request->input('email'))
            ChangeEmail::dispatchFromForm($user, $request);

        if ($request->has('password'))
            ChangePassword::dispatchFromForm($user, $request);

        return redirect()->route('showProfile');    
    }

    public function showUsers(Request $request) 
    {
        $this->authorize('users.show');
        $search = $request->input('naam', '');
        $regions = $this->regions->all();
        $oudLeden = $request->input('oudleden');

        if (!($region = $request->input('regio') and $this->regions->exists($region)))
            $region = null;

        if (!($yearGroup = $request->input('jaarverband') and $this->yearGroups->exists($yearGroup)))
            $yearGroup = null;

        $perPage = 50;
        $types = $oudLeden == '1' ? [UserTypeEnum::MEMBER, UserTypeEnum::REUNIST, UserTypeEnum::EXMEMBER] : UserTypeEnum::MEMBER;
        $members = $this->profiles->searchAndPaginate($search, $region, $yearGroup, $types, $perPage);

        $yearGroups = $this->yearGroups->all();

        return view('users.index', [
            'members' => $members,
            'regions' => $regions,
            'yearGroups' => $yearGroups,
        ]);
    }
}
