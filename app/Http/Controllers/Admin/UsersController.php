<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use GSVnet\Users\UsersRepository;

class UsersController extends Controller  
{
    protected $users;

    public function __construct(
        UsersRepository $users,
    ) {
        $this->users = $users;
    }

    public function show($id)
    {
        $this->authorize('usersShow', User::class);
        $user = $this->users->byId($id);

        //Committes, ordinary forum users or users without profile (due to GDPF for ex.)
        if ((!$user->isMemberOrReunist() && !$user->isPotential()) || !$user->profile)
            return view('admin.users.show', [
                'user' => $user,
            ]);

        $profile = $user->profile()->get();

        //Members, former members
        if ($user->isMemberOrReunist()) {
            $committees = $user->committeesSorted()->get();

            if (!$user->profile->alive) {
                return view('admin.users.showDeceasedMember', [
                    'user' => $user,
                    'profile' => $profile,
                    'committees' => $committees
                ]);
            }

            return view('admin.users.showMember', [
                'user' => $user,
                'profile' => $profile,
                'committees' => $committees
            ]);
        }

        // Potentials
        return view('admin.users.showPotential', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

}