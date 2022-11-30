<?php namespace App\Http\Controllers;

use GSVnet\Committees\CommitteesRepository;
use GSVnet\Senates\SenatesRepository;

class AboutController extends Controller 
{
    private $committees;
    private $senates;

    public function __construct(
        CommitteesRepository $committees,
        SenatesRepository $senates
        ) {
        $this->committees = $committees;
        $this->senates = $senates;
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

    public function showSenates() {
        $senates = $this->senates->all();

        return view('senates.index', [
            'senates' => $senates
        ]);
    }
}
