<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ChangeName;
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

    public function updateName(Request $request, User $user)
    {
        ChangeName::dispatch($request, $user);

        session()->flash('success', "Naam {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action('Admin\UsersController@show', $user->id);
    }
}
