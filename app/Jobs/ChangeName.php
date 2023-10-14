<?php

namespace App\Jobs;

use App\Events\Members\NameWasChanged;
use App\Http\Requests\UpdateNameRequest;
use App\Models\User;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangeName implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private User $manager;
    private array $data;

    /**
     * Create a new job instance.
     */
    public function __construct(
        UpdateNameRequest $request, 
        private User $member // Promoted property
    ) {
        $this->manager = $request->user();
        $this->data = $request->all();
    }

    /**
     * Execute the job.
     */
    public function handle(
        UsersRepository $users,
        ProfilesRepository $profiles
    ): void
    {
        $this->member->profile->initials = $this->data['initials'];
        $this->member->firstname = $this->data['firstname'];
        $this->member->middlename = $this->data['middlename'];
        $this->member->lastname = $this->data['lastname'];

        $users->save($this->member);
        $profiles->save($this->member->profile);

        NameWasChanged::dispatch($this->member, $this->manager);
    }
}
