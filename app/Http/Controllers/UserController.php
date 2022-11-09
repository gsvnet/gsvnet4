<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Commands\Users\ChangeEmail;
use App\Commands\Users\ChangePassword;


use GSVnet\Users\UsersRepository;
use GSVnet\Committees\CommitteesRepository;
use GSVnet\Regions\RegionsRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

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
            'password' => ['sometimes', 'confirmed', Password::defaults()]
        ], [
            'password.confirmed' => 'Verschillende wachtwoorden ingevuld',
            'email.required' => 'Email moet ingevuld zijn',
            'email.email' => 'Email is geen geldig adres',
            'email.unique' => 'Email is al in gebruik'
        ]);
        $data = $request->only('email', 'password', 'password_confirmation');

        //ADD PASSWORD CHANGE MODULE; THEN THIS ROUTE IS FINISHED
        if ($user->email != $data['email']) {
            event(ChangeEmail::fromForm($request, $user));
        }

        if (!empty($data['password'])) {
            event(ChangePassword::fromForm($request, $user));
        }

        return redirect()->route('showProfile');    
    }
}
