<?php namespace App\Http\Controllers\Admin;

use App\Events\Potentials\PotentialWasAccepted;
use App\Events\Users\UserWasActivated;
use App\Exports\MembersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Jobs\StoreUser;
use App\Models\User;
use App\Models\UserProfile;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Regions\RegionsRepository;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\YearGroupRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// TODO: Create views

class UsersController extends Controller  
{

    public function __construct(
        protected UsersRepository $users,
        protected ProfilesRepository $profiles,
        protected YearGroupRepository $yearGroups,
        protected RegionsRepository $regions,
    ) {}

    /**
     * Show an overview of all users.
     * @return \Illuminate\Contracts\View\View
     */
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

    public function showMembers(Request $request)
    {
        // $this->authorize('users.show'); TO DO: AUTHORIZE LIKE THIS DOES NOT WORK
        $search = $request->get('zoekwoord', '');
        $type = UserTypeEnum::MEMBER;
        $perPage = 300;

        // Search on region
        if (!($region = $request->get('regio') and $this->regions->exists($region)))
            $region = null;

        // Enable search on yeargroup
        if (!($yearGroup = $request->get('jaarverband') and $this->yearGroups->exists($yearGroup)))
            $yearGroup = null;

        $profiles = $this->profiles->searchAndPaginate($search, $region, $yearGroup, $type, $perPage);
        $yearGroups = $this->yearGroups->all();
        $regions = $this->regions->all();

        return view('admin.users.leden')->with('profiles', $profiles)
            ->with('yearGroups', $yearGroups)
            ->with('regions', $regions);
    }

    public function showFormerMembers(Request $request)
    {
        $this->authorize('users.show');
        $search = $request->get('zoekwoord', '');
        $perPage = 300;
        // TODO: Check that an array of types can be retrieved in this way from HTML form
        $types = $request->enum('type', UserTypeEnum::class);

        // Search on region
        if (!($region = $request->get('regio') and $this->regions->exists($region)))
            $region = null;

        // Enable search on yeargroup
        if (!($yearGroup = $request->get('jaarverband') and $this->yearGroups->exists($yearGroup)))
            $yearGroup = null;

        $profiles = $this->profiles->searchAndPaginate($search, $region, $yearGroup, $types, $perPage);
        $yearGroups = $this->yearGroups->all();
        $regions = $this->regions->all();

        return view('admin.users.oud-leden')->with('profiles', $profiles)
            ->with('yearGroups', $yearGroups)
            ->with('regions', $regions);
    }

    /**
     * Return a view of the user dependent on the user type.
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $this->authorize('users.show');

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

    /**
     * Download an Excel file containing member information.
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportMembers()
    {
        $this->authorize('users.show');
        return (new MembersExport())->download('leden.xlsx');
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request) : RedirectResponse {
        // Authorization and validation handled by request class
        $input = $request->only('username', 'type', 'firstname', 'middlename', 'lastname', 'email', 'password');
        StoreUser::dispatch($input);

        $request->session()->flash('success', 'Gebruiker is succesvol opgeslagen.');

        return redirect()->route('dashboard');
    }

    /**
     * Delete the user (and their profile, if it exists) from the database.
     * @param \App\Models\User $user
     * @return RedirectResponse|mixed
     */
    public function destroy(User $user)
    {
        $this->authorize('users.manage');

        if ($profile = $user->profile)
            $profile->delete();

        $user->delete();

        session()->flash('success', 'Account is succesvol verwijderd.');

        return redirect()->action('Admin\UsersController@index');
    }

    /**
     * Stores a UserProfile for $user. 
     * 
     * Not in its own controller because we do not want people bypass the user when interacting with the profile.
     * @param \App\Http\Requests\StoreProfileRequest $request
     * @param \App\Models\User $user
     * @return RedirectResponse|mixed
     */
    public function storeProfile(StoreProfileRequest $request, User $user)
    {
        $input['user_id'] = $user->id;
        UserProfile::create($input);

        session()->flash('success', "GSV-profiel gecreëerd voor {$user->present()->fullName}.");

        return redirect()->action('Admin\UsersController@edit', $user->id);
    }

    /**
     * Destroys profile of $user.
     * @param \App\Models\User $user
     * @return RedirectResponse|mixed
     */
    public function destroyProfile(User $user)
    {
        $this->authorize('users.manage');
        $user->profile()->delete();

        session()->flash('success', "Profiel van {$user->present()->fullName} is succesvol verwijderd.");

        return redirect()->action('Admin\UsersController@edit', $user->id);
    }

    /**
     * Updates a profile for $user.
     * @param \App\Http\Requests\UpdateProfileRequest $request
     * @param \App\Models\User $user
     * @return RedirectResponse|mixed
     */
    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $input = $request->only(
            'region', 'year_group_id', 'inauguration_date', 'initials', 'phone', 
            'address', 'zip_code', 'town', 'study', 'student_number', 'birthdate', 
            'gender'
        );
        $input['user_id'] = $user->id;

        // Set some specific info for former members
        if ($user->isFormerMember()) {
            $input['reunist'] = $request->get('reunist', '0') === '1';
            $input['resignation_date'] = $request->get('resignation_date');
            $input['company'] = $request->get('company');
            $input['profession'] = $request->get('profession');
        }

        // Natural parents
        if ($user->isMember()) {
            $input = array_merge($input, $request->only('parent_phone', 'parent_email', 'parent_address', 'parent_zip_code', 'parent_town'));
        }

        // Check if the region is valid
        if (!$this->regions->exists($input['region'])) {
            $input['region'] = null;
        }

        // Update
        $user->profile()->update($input);

        session()->flash('success', "Profiel van {$user->present()->fullName} is succesvol bijgewerkt.");

        return redirect()->action('Admin\UsersController@show', $user->id);
    }

    /**
     * Activate user account (can also be applied to potentials).
     * @param \App\Models\User $user
     * @return RedirectResponse|mixed
     */
    public function activate(User $user)
    {
        $this->authorize('users.manage');

        $this->users->activateUser($user);

        UserWasActivated::dispatch($user);

        session()->flash('success', "Account van {$user->present()->fullName} is succesvol geactiveerd.");

        return redirect()->action('Admin\UsersController@index');
    }

    /**
     * Accept potential as member.
     * @param User $user
     * @return RedirectResponse|mixed
     */
    public function accept(User $user)
    {
        $this->authorize('users.manage');

        $this->users->acceptMembership($user);

        PotentialWasAccepted::dispatch($user);

        session()->flash('success', "Noviet {$user->present()->fullName} is succesvol geïnstalleerd.");

        return redirect()->action('Admin\UsersController@index');
    }
}