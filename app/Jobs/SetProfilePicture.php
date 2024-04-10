<?php

namespace App\Jobs;

use App\Events\Members\ProfilePictureWasChanged;
use App\Models\User;
use GSVnet\Core\ImageHandler;
use GSVnet\Core\Exceptions\PhotoStorageException;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetProfilePicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $member,
        protected User $manager,
        private string $path
    ) {}

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $profile = $this->member->profile;

        $profile->photo_path = $this->path;
        $profiles->save($profile);

        if ($this->member->isMemberOrReunist())
            ProfilePictureWasChanged::dispatch($this->member, $this->manager);
    }
}
