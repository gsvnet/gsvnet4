<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateContactDetailsRequest;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdateUsernameRequest;
use App\Jobs\ChangeAddress;
use App\Jobs\ChangeName;
use App\Jobs\ChangePhone;
use App\Jobs\ChangeUsername;
use App\Models\User;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\ProfileActions\ProfileActionsRepository;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\YearGroupRepository;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(
        private ProfileActionsRepository $actions,
        private UsersRepository $users,
        private YearGroupRepository $yeargroups,
        private RegionsRepository $regions
    ) {}

    public function latestUpdates()
    {
        $changes = $this->actions->latestUpdatesWithMembers();
        return view('admin.users.latestUpdates')->with(compact('changes'));
    }

    public function editName(User $user)
    {
        $this->authorize('user.manage.name', $user);
        return view('admin.users.update.name')->with(compact('user'));
    }

    public function updateName(UpdateNameRequest $request, User $user)
    {
        ChangeName::dispatch($request, $user);

        session()->flash('success', "Naam {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editUsername(User $user)
    {
        $this->authorize('users.manage.name');
        return view('admin.users.update.username')->with(compact('user'));
    }

    public function updateUsername(UpdateUsernameRequest $request, User $user)
    {
        ChangeUsername::dispatch($request, $user);

        session()->flash('success', "Gebruikersnaam {$user->username} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editContactDetails(User $user)
    {
        $this->authorize('user.manage.address', $user);
        $this->authorize('user.manage.phone', $user);
        return view('admin.users.update.contact')->with(compact('user'));
    }

    public function updateContactDetails(UpdateContactDetailsRequest $request, User $user)
    {
        ChangeAddress::dispatch($request, $user);
        ChangePhone::dispatch($request, $user);

        session()->flash('success', "Contactgegevens {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }
}
