<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSenateRequest;
use App\Http\Requests\UpdateSenateRequest;
use App\Jobs\ChangeSenate;
use App\Jobs\StoreSenate;
use App\Models\Senate;
use GSVnet\Senates\SenatesRepository;
use GSVnet\Users\UsersRepository;
use Illuminate\Http\Request;

class SenateController extends Controller
{
    public function __construct(
        private SenatesRepository $senates,
        private UsersRepository $users
    ) {
        $this->authorize('senates.manage');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $senates = $this->senates->paginate(20);
        $users = $this->users->all();

        return view('admin.senates.index')
            ->with(compact('senates', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSenateRequest $request)
    {
        StoreSenate::dispatch($request);

        $name = $request->get('name');

        session()->flash('success', "{$name} is succesvol opgeslagen.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Senate $senate)
    {
        $members = $senate->members;

        $users = $this->users->all();
        $users = $users->map(function($user) {
            return [
                'id' => $user->id, 
                'name' => $user->present()->fullName
            ];
        });

        return view('admin.senates.show')
            ->with(compact('senate', 'members', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Senate $senate)
    {
        $members = $senate->members;

        $users = $this->users->all();
        $users = $users->map(function($user) {
            return [
                'id' => $user->id, 
                'name' => $user->present()->fullName
            ];
        });

        return view('admin.senates.edit')
            ->with(compact('senate', 'members', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSenateRequest $request, Senate $senate)
    {
        ChangeSenate::dispatch($senate, $request);

        session()->flash('success', "{$senate->name} is succesvol bewerkt.");

        return redirect()->action([$this::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Senate $senate)
    {
        $this->senates->delete($senate->id);

        session()->flash('success', "{$senate->name} is succesvol verwijderd.");

        return redirect()->action([$this::class, 'index']);
    }
}
