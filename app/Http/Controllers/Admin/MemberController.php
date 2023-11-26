<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBirthdayRequest;
use App\Http\Requests\UpdateContactDetailsRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdateGenderRequest;
use App\Http\Requests\UpdateMembershipPeriodRequest;
use App\Http\Requests\UpdateNameRequest;
use App\Http\Requests\UpdateParentContactDetailsRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Http\Requests\UpdateUsernameRequest;
use App\Jobs\ChangeAddress;
use App\Jobs\ChangeAlive;
use App\Jobs\ChangeBirthday;
use App\Jobs\ChangeBusiness;
use App\Jobs\ChangeEmail;
use App\Jobs\ChangeGender;
use App\Jobs\ChangeMembershipPeriod;
use App\Jobs\ChangeMembershipStatus;
use App\Jobs\ChangeName;
use App\Jobs\ChangeParentsDetails;
use App\Jobs\ChangePassword;
use App\Jobs\ChangePhone;
use App\Jobs\ChangeRegion;
use App\Jobs\ChangeStudy;
use App\Jobs\ChangeUsername;
use App\Jobs\ChangeYearGroup;
use App\Jobs\ForgetMember;
use App\Jobs\SetProfilePicture;
use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
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
        private YearGroupRepository $yearGroups,
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
        ChangeName::dispatchFromForm($user, $request);

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
        ChangeUsername::dispatchFromForm($user, $request);

        session()->flash('success', "Gebruikersnaam {$user->username} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editContactDetails(User $user)
    {
        $this->authorize('user.manage.address', $user);
        $this->authorize('user.manage.phone', $user);
        return view('admin.users.update.contact')->with(compact('user'));
    }

    public function updateContactDetails(
        UpdateContactDetailsRequest $request, 
        User $user
    ) {
        ChangeAddress::dispatchFromForm($user, $request);
        ChangePhone::dispatchFromForm($user, $request);

        session()->flash('success', "Contactgegevens {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editParentContactDetails(User $user)
    {
        $this->authorize('user.manage.parents', $user);
        return view('admin.users.update.parents')->with(compact('user'));
    }

    public function updateParentContactDetails(
        UpdateParentContactDetailsRequest $request, 
        User $user
    ) {
        ChangeParentsDetails::dispatchFromForm($user, $request);

        session()->flash('success', "Gegevens van {$user->present()->fullName()}s ouders succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editBirthDay(User $user)
    {
        $this->authorize('user.manage.birthday', $user);
        return view('admin.users.update.birthday')->with(compact('user'));
    }

    public function updateBirthDay(UpdateBirthdayRequest $request, User $user)
    {
        ChangeBirthday::dispatchFromForm($user, $request);

        session()->flash('success', "Geboortedatum van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editEmail(User $user)
    {
        $this->authorize('user.manage.email', $user);
        return view('admin.users.update.email')->with(compact('user'));
    }

    public function updateEmail(UpdateEmailRequest $request, User $user)
    {
        ChangeEmail::dispatchFromForm($user, $request);

        session()->flash('success', "E-mailadres van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editPassword(User $user)
    {
        $this->authorize('user.manage.password', $user);
        return view('admin.users.update.password')->with(compact('user'));
    }

    public function updatePassword(UpdatePasswordRequest $request, User $user)
    {
        ChangePassword::dispatchFromForm($user, $request);

        session()->flash('success', "Wachtwoord van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editGender(User $user)
    {
        $this->authorize('user.manage.gender', $user);
        return view('admin.users.update.gender')->with(compact('user'));
    }

    public function updateGender(UpdateGenderRequest $request, User $user)
    {
        ChangeGender::dispatchFromForm($user, $request);

        session()->flash('success', "Geslacht van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editYearGroup(User $user)
    {
        $this->authorize('users.manage');

        $yearGroups = $this->yearGroups->all();
        return view('admin.users.update.yeargroup')->with(compact('user', 'yearGroups'));
    }

    public function updateYearGroup(Request $request, User $user)
    {
        ChangeYearGroup::dispatchFromForm($user, $request);

        session()->flash('success', "Jaarverband van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editBusiness(User $user)
    {
        $this->authorize('user.manage.business', $user);
        return view('admin.users.update.business')->with(compact('user'));
    }

    public function updateBusiness(Request $request, User $user)
    {
        // No validation restrictions
        $this->authorize('user.manage.business', $user);

        ChangeBusiness::dispatchFromForm($user, $request);

        session()->flash('success', "Werk van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editStudy(User $user)
    {
        $this->authorize('user.manage.study', $user);

        return view('admin.users.update.study')->with(compact('user'));
    }

    public function updateStudy(Request $request, User $user)
    {
        // No validation restrictions
        $this->authorize('user.manage.study', $user);

        ChangeStudy::dispatchFromForm($user, $request);

        session()->flash('success', "Studie van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editMembershipPeriod(User $user)
    {
        $this->authorize('users.manage');

        return view('admin.users.update.membershipPeriod')->with(compact('user'));
    }

    public function updateMembershipPeriod(
        UpdateMembershipPeriodRequest $request, 
        User $user
    ) {
        ChangeMembershipPeriod::dispatchFromForm($user, $request);

        session()->flash('success', "Periode van lidmaatschap van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editRegion(User $user)
    {
        $this->authorize('users.manage');

        $userRegions = $user->profile->regions;

        $currentRegions = $this->regions->current();
        $formerRegions = $this->regions->former();

        return view('admin.users.update.region')->with(compact('user', 'userRegions', 'currentRegions', 'formerRegions'));
    }

    public function updateRegion(UpdateRegionRequest $request, User $user)
    {
        ChangeRegion::dispatchFromForm($user, $request);

        session()->flash('success', "Regio van {$user->present()->fullName()} succesvol aangepast");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editMembershipStatus(User $user)
    {
        $this->authorize('users.manage');

        return view('admin.users.update.membership')->with(compact('user'));
    }

    public function makeReunist(Request $request, User $user)
    {
        $this->authorize('users.manage');

        ChangeMembershipStatus::dispatch(UserTypeEnum::REUNIST, $user, $request->user());

        session()->flash('success', "{$user->present()->fullName()} is nu reünist");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function makeExMember(Request $request, User $user)
    {
        $this->authorize('users.manage');

        ChangeMembershipStatus::dispatch(UserTypeEnum::EXMEMBER, $user, $request->user());

        session()->flash('success', "{$user->present()->fullName()} is nu oud-lid");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function makeMember(Request $request, User $user)
    {
        $this->authorize('users.manage');

        ChangeMembershipStatus::dispatch(UserTypeEnum::MEMBER, $user, $request->user());

        session()->flash('success', "{$user->present()->fullName()} is nu lid");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editPhoto(User $user)
    {
        $this->authorize('user.manage.photo', $user);

        return view('admin.users.update.photo')->with(compact('user'));
    }

    public function updatePhoto(UpdatePhotoRequest $request, User $user)
    {
        if ($request->hasFile('photo_path'))
            SetProfilePicture::dispatchFromForm($user, $request);

        session()->flash('success', "Foto van {$user->present()->fullName()} succesvol opgeslagen");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    public function editAlive(User $user)
    {
        $this->authorize('users.manage');

        return view('admin.users.update.alive')->with(compact('user'));
    }

    public function updateAlive(Request $request, User $user)
    {
        $this->authorize('users.manage');

        ChangeAlive::dispatchFromForm($user, $request);

        session()->flash('success', "Status gewijzigd");
        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }

    // ...more methods...

    public function setForget(User $user)
    {
        $this->authorize('users.manage');

        return view('admin.users.settingsForget')->with(compact('user'));
    }

    public function forget(Request $request, User $user)
    {
        $this->authorize('users.manage');

        ForgetMember::dispatchFromForm($request, $user);

        session()->flash('success', "Profiel en account opgeschoond.");

        return redirect()->action([UsersController::class, 'show'], ['user' =>$user->id]);
    }
}
