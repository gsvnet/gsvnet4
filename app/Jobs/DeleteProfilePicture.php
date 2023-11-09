<?php

namespace App\Jobs;

use App\Events\Members\ProfilePictureWasChanged;
use App\Models\User;
use GSVnet\Core\ImageHandler;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteProfilePicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $member, 
        protected User $manager
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ImageHandler $imageHandler, ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;

        $imageHandler->destroy($profile->photo_path);
        
        $profile->photo_path = null;
        $profiles->save($profile);

        if ($this->member->isMemberOrReunist()) 
            ProfilePictureWasChanged::dispatch($this->member, $this->manager);
    }
}
