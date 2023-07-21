<?php namespace App\Http\Controllers\Admin;

use App\Exports\MembersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Jobs\StoreUser;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\YearGroupRepository;
use Illuminate\Http\RedirectResponse;

class UsersController extends Controller  
{
    protected $users;
    protected $profiles;
    protected $yearGroups;
    protected $regions;

    public function __construct(
        UsersRepository $users,
        ProfilesRepository $profiles,
        YearGroupRepository $yearGroups,
        RegionsRepository $regions,
    ) {
        $this->users = $users;
        $this->profiles = $profiles;
        $this->yearGroups = $yearGroups;
        $this->regions = $regions;
    }

    public function index()
    {
        $this->authorize('users.show');
        $users = $this->users->paginateLatelyRegistered(50);

        return view('admin.users.index')->with('users', $users);
    }

    public function showGuests()
    {
        $this->authorize('users.show');
        $users = $this->users->paginateLatestRegisteredGuests(50);

        return view('admin.users.visitors')->with('users', $users);
    }

    public function showPotentials()
    {
        $this->authorize('users.show');
        $users = $this->users->paginateLatestPotentials(50);

        return view('admin.users.potentials')->with(['users' => $users]);
    }

    public function show($id)
    {
        $this->authorize('users.show');
        $user = $this->users->byId($id);

        // Committees or ordinary forum users do not need a fancy profile page.
        // In addition, since GDPR, not all (former) members still have profiles.
        if ((!$user->isMemberOrReunist() && !$user->isPotential()) || !$user->profile)
            return view('admin.users.show')->with(compact('user'));

        $profile = $user->profile;

        if ($user->isMemberOrReunist()) {
            // Members, former members
            $committees = $user->committeesSorted;

            if (! $user->profile->alive) {
                return view('admin.users.showDeceasedMember')->with(compact('user', 'profile', 'committees'));
            }

            return view('admin.users.showMember')->with(compact('user', 'profile', 'committees'));
        }

        // Potentials
        return view('admin.users.showPotential')->with(compact('user', 'profile'));
    }

    public function exportMembers()
    {
        $this->authorize('users.show');
        return (new MembersExport())->download('leden.xlsx');
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request) : RedirectResponse {
        $this->authorize('users.manage');
        // Authorization and validation handled by request class
        $input = $request->only('username', 'type', 'firstname', 'middlename', 'lastname', 'email', 'password');
        StoreUser::dispatch($input);

        $request->session()->flash('success', 'Gebruiker is succesvol opgeslagen.');

        return redirect()->route('dashboard');
    }
}