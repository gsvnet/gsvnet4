<?php

namespace App\Http\Controllers\Admin\Committees;

use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeMemberRequest;
use App\Http\Requests\UpdateCommitteeMemberRequest;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct() {
        $this->authorize('committees.manage');
    }

    /**
     * Add `$member` to `$committee`.
     */
    public function store(
        StoreCommitteeMemberRequest $request, 
        Committee $committee, 
        User $member
    ) {
        $committee->members()->attach($member->id, $request->only('start_date', 'end_date'));

        session()->flash('success', "{$member->present()->fullName} succesvol toegevoegd aan {$committee->name}.");

        return redirect()->action([CommitteeController::class, 'show'], $committee->id);
    }

    public function edit(Committee $committee, User $member)
    {
        $membership = $committee->members()->find($member->id)->pivot;

        return view('admin.committees.edit-membership')
            ->with(compact('committee', 'member', 'membership'));
    }

    /**
     * Update start and end dates of committee membership.
     */
    public function update(
        UpdateCommitteeMemberRequest $request, 
        Committee $committee, 
        User $member
    ) 
    {
        // Sets end_date to null if not provided
        $committee->members()->updateExistingPivot($member->id, [
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        ]);

        session()->flash('success', "Commissiewerk van {$member->present()->fullName} voor {$committee->name} is succesvol bijgewerkt.");

        return redirect()->action([CommitteeController::class, 'show'], $committee->id);
    }

    /**
     * Remove `$member` from `$committee`.
     */
    public function destroy(Committee $committee, User $member)
    {
        $committee->members()->detach($member->id);

        session()->flash('success', "{$member->present()->fullName} succesvol verwijderd uit {$committee->name}");

        return redirect()->action([CommitteeController::class, 'show'], $committee->id);
    }
}
