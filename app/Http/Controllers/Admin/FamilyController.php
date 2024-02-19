<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use GSVnet\Users\UsersRepository;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function __construct(private UsersRepository $users)
    {
        $this->authorize('users.manage');
    }

    public function index(User $user)
    {
        $children = $user->children;
        $parent = $user->parents->first();

        return view('admin.family.index')->with('user', $user)
            ->with('children', $children)
            ->with('parent', $parent);
    }

    public function store(Request $request, User $user)
    {
        $parent = [$request->get('parentId')];
        $children = $request->get('childrenIds');

        if(is_array($children))
        {
            $childrenIds = $this->users->filterExistingIds($children);
            $user->children()->sync($childrenIds->all());
        }

        $parentId = $this->users->filterExistingIds($parent);
        $user->parents()->sync($parentId->all());

        session()->flash('success', "De familie van {$user->present()->fullName} is bijgewerkt.");

        return redirect()->back();
    }
}
