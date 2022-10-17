<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

use GSVnet\Users\UsersRepository;
use GSVnet\Committees\CommitteesRepository;
use Illuminate\Support\Facades\Log;

//Work in progress, can't be extended since authentication is required
class UserController extends Controller
{
    protected $users;
    protected $committees;

    public function __construct(
        UsersRepository $users,
        CommitteesRepository $committees,
    ) {
        $this->users = $users;
        $this->committees = $committees;
    }


    public function showProfile()
    {
        $id = Auth::id();
        $member = $this->users->byId($id);
        $committees = $this->committees->byUserOrderByRecent($member);

        return view('userprofile', [
            'user' => $member,
            'committees' => "Something like relational table has to be implemented"
        ]);
    }
}
