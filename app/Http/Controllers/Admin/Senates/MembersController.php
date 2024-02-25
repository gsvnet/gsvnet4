<?php

namespace App\Http\Controllers\Admin\Senates;

use App\Http\Controllers\Admin\SenateController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSenateMemberRequest;
use App\Models\Senate;
use App\Models\User;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    public function __construct() {
        $this->authorize('senates.manage');
    }

    /**
     * Add `$member` to `$senate`.
     */
    public function store(
        StoreSenateMemberRequest $request,
        Senate $senate, 
        User $member
    ) {
        $senate->members()->attach($member->id,  [
            'function' => $request->get('function')
        ]);

        session()->flash('success', "{$member->present()->fullName} succesvol toegevoegd aan {$senate->name}.");

        return redirect()->action([SenateController::class, 'show'], $senate->id);
    }

    /**
     * Remove `$member` from `$senate`.
     */
    public function destroy(Senate $senate, User $member)
    {
        $senate->members()->detach($member->id);

        session()->flash('success', "{$member->present()->fullName} succesvol uit de senaat geknikkerd.");

        return redirect()->action([SenateController::class, 'show'], $senate->id);
    }
}
