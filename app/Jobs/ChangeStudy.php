<?php

namespace App\Jobs;

use App\Events\Members\StudyWasChanged;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\ValueObjects\Study;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;

class ChangeStudy extends ChangeProfileDetail
{
    public function __construct(
        protected User $member, 
        protected User $manager, 
        private Study $study
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch 
    {
        $study = new Study(
            $request->get('study'),
            $request->get('student_number')
        );

        return new PendingDispatch(new static($member, $request->user(), $study));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;
        $profile->study = $this->study->getStudy();
        $profile->student_number = $this->study->getStudentNumber();

        $profiles->save($profile);

        StudyWasChanged::dispatch($this->member, $this->manager);
    }
}
