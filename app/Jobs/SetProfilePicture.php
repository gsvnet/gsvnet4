<?php

namespace App\Jobs;

use App\Events\Members\ProfilePictureWasChanged;
use App\Models\User;
use GSVnet\Core\ImageHandler;
use GSVnet\Core\Exceptions\PhotoStorageException;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class SetProfilePicture extends ChangeProfileDetail
{
    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $member,
        protected User $manager,
        private UploadedFile $file
    ) {}

    static function dispatchFromForm(User $member, Request $request): PendingDispatch
    {
        $file = $request->file('photo_path');

        return new PendingDispatch(new static($member, $request->user(), $file));
    }

    /**
     * Execute the job.
     */
    public function handle(ProfilesRepository $profiles): void
    {
        $imageHandler = new ImageHandler("/uploads/images/users");
        $profile = $this->member->profile;

        // If old photo is present, destroy it.
        $imageHandler->destroy($profile->photo_path);

        // Upload new photo. Path is generated by the system.
        if (!$path = $imageHandler->store($this->file))
            throw new PhotoStorageException;

        $profile->photo_path = $path;
        $profiles->save($profile);

        if ($this->member->isMemberOrReunist())
            ProfilePictureWasChanged::dispatch($this->member, $this->manager);
    }
}
