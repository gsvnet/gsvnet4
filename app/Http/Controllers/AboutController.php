<?php namespace App\Http\Controllers;

use App\Models\Senate;
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

    public function showCommittees() 
    {
        $allCommittees = $this->committees->all();

        return view('committees.index', [
            'committees' => $allCommittees
        ]);
    }

    public function showCommittee($slug)
    {
        $committee = $this->committees->bySlug($slug);
        $activeMembers = $committee->activeMembers;
        $previousMembers = $committee->previousMembersTwoYear;

        return view('committees.show', [
            'committee' => $committee,
            'activeMembers' => $activeMembers,
            'previousMembers' => $previousMembers
        ]);
    }

    public function showSenates()
    {
        $senates = $this->senates->all();

        return view('senates.index', [
            'senates' => $senates
        ]);
    }

    public function showSenate(Senate $senate)
    {
        $members = $senate->members;
        $allSenates = $this->senates->all();

        return view('senates.show', [
            'senate' => $senate,
            'senates' => $allSenates,
            'members' => $members
        ]);
    }

    public function showFormerMembers()
    {
        return view('de-gsv.former-members');
    }

    public function showConfidants()
    {
        return view('de-gsv.confidants');
    }

    public function showContact()
    {
        return view('de-gsv.contact');
    }

    public function showPillars()
    {
        return view('de-gsv.pillars');
    }

    public function showHistory()
    {
        return view('de-gsv.history');
    }
}
