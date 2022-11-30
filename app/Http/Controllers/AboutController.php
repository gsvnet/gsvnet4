<?php namespace App\Http\Controllers;

use GSVnet\Committees\CommitteesRepository;

class AboutController extends Controller 
{
    private $committees;

    public function __construct(
        CommitteesRepository $committees
    ) {
        $this->committees = $committees;
    }

    public function showCommittees() {
        $allCommittees = $this->committees->all();

        return view('committees.index', [
            'committees' => $allCommittees
        ]);
    }

    public function showCommittee($slug)
    {
        $committee = $this->committees->bySlug($slug);
        $allCommittees = $this->committees->all();
        $activeMembers = $committee->activeMembers;

        return view('committees.show', [
            'committee' => $committee,
            'committees' => $allCommittees,
            'activeMembers' => $activeMembers
        ]);
    }
}
