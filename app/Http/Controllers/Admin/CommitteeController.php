<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommitteeRequest;
use App\Http\Requests\UpdateCommitteeRequest;
use App\Jobs\ChangeCommittee;
use App\Jobs\StoreCommittee;
use App\Models\Committee;
use GSVnet\Committees\CommitteesRepository;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Users\UsersRepository;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function __construct(
        private CommitteesRepository $committees,
        private UsersRepository $users
    ) {
        $this->authorize('committees.manage');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $committees = $this->committees->paginate(100);
        $users = $this->users->byType(UserTypeEnum::MEMBER);

        return view('admin.committees.index')
            ->with(compact('committees', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommitteeRequest $request)
    {
        StoreCommittee::dispatch($request);

        $name = $request->get('name');

        session()->flash('success', "Commissie {$name} is succesvol opgeslagen.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Committee $committee)
    {
        $members = $committee->members;

        $users = $this->users->all();
        $users = $users->map(function($user) {
            return [
                'id' => $user->id, 
                'name' => $user->present()->fullName()
            ];
        });

        return view('admin.committees.show')
            ->with(compact('committee', 'users', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Committee $committee)
    {
        $members = $committee->users;

        return view('admin.committees.edit')
            ->with(compact('committee', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommitteeRequest $request, Committee $committee)
    {
        ChangeCommittee::dispatch($committee, $request);

        session()->flash('success', "Commissie {$committee->name} is succesvol bijgewerkt.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Committee $committee)
    {
        $this->committees->delete($committee->id);

        session()->flash('success', "{$committee->title} is succesvol verwijderd.");

        return redirect()->action([$this::class, 'index']);
    }
}
