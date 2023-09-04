<?php

namespace App\Jobs;

use App\Events\Users\UserWasRegistered;
use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $data
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $this->data['password'] = bcrypt($this->data['password']);
        $this->data['type'] = UserTypeEnum::from($this->data['type']);
        $this->data['approved'] = true;

        $user = User::create($this->data);

        // Create a profile for potentials, members and former members
        if($user->type != UserTypeEnum::VISITOR && $user->type != UserTypeEnum::EXMEMBER)
            $profiles->createProfileFor($user);

        UserWasRegistered::dispatch($user);
    }
}
