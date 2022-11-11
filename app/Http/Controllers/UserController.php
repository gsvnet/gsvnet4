<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Commands\Users\ChangeEmail;
use App\Handlers\Users\ChangeEmailHandler;
use App\Commands\Users\ChangePassword;
use App\Handlers\Users\ChangePasswordHandler;


use GSVnet\Users\UsersRepository;
use GSVnet\Committees\CommitteesRepository;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\YearGroupRepository;
use GSVnet\Users\ProfilesRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

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

        return view('users.user-profile', [
            'user' => $member,
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

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()]
        ], [
            'password.confirmed' => 'Verschillende wachtwoorden ingevuld',
            'email.required' => 'Email moet ingevuld zijn',
            'email.email' => 'Email is geen geldig adres',
            'email.unique' => 'Email is al in gebruik'
        ]);
        $data = $request->only('email', 'password', 'password_confirmation');

        if ($user->email != $data['email']) {
            ChangeEmailHandler::dispatch($request->input('email'), $user, $user);
        }

        if (!empty($data['password'])) {
            ChangePasswordHandler::dispatch($request->input('password'), $user);
        }

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
        $types = $oudLeden == '1' ? [User::MEMBER, User::REUNIST, User::EXMEMBER] : User::MEMBER;
        $members = $this->profiles->searchAndPaginate($search, $region, $yearGroup, $types, $perPage);

        $yearGroups = $this->yearGroups->all();

        return view('users.index', [
            'members' => $members,
            'regions' => $regions,
            'yearGroups' => $yearGroups,
        ]);
    }
}
