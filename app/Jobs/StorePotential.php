<?php

namespace App\Jobs;

use App\Events\Potentials\PotentialWasRegistered;
use App\Models\User;
use Carbon\Carbon;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Users\Profiles\ProfilesRepository;
use GSVnet\Users\UsersRepository;
use GSVnet\Users\ValueObjects\Address;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class StorePotential implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Carbon $birthday;
    private array $parentData;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
        private Request $request
    ) {
        // Transform data so it fits the other jobs
        $this->birthday = Carbon::createFromDate(
            ...$request->only(['birthYear', 'birthMonth', 'birthDay'])
        );

        $this->parentData = $request->only([
            "parent_address", "parent_zip_code", "parent_town",
            "parent_phone", "parent_email"
        ]);

        // Check if parent address is the same as potential address
        if ($request->get('parents-same-address', '0') == '1') {
            $this->parentData['parent_address'] = $request->get('address');
            $this->parentData['parent_town'] = $request->get('town');
            $this->parentData['parent_zip_code'] = $request->get('zipCode');
        }
    }

    /**
     * Execute the job.
     */
    public function handle(
        UsersRepository $users,
        ProfilesRepository $profiles
    ): void {
        // User themselves
        $user = $this->user;
        $request = $this->request;

        if (is_null($user)) {
            $user = new User([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'middlename' => $request->get('middlename'),
                'lastname' => $request->get('lastname'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'type' => UserTypeEnum::POTENTIAL
            ]);
        } else {
            $user->fill([
                'username' => $request->get('username'),
                'firstname' => $request->get('firstname'),
                'middlename' => $request->get('middlename'),
                'lastname' => $request->get('lastname'),
                'type' => UserTypeEnum::POTENTIAL
            ]);
        }

        $users->save($user);

        // Create empty profile, fill all parts
        $profiles->createProfileFor($user);

        // TODO: Allow these to execute silently, without events firing
        ChangeGender::dispatchFromForm($user, $request);
        ChangeBirthday::dispatch($user, $request->user(), $this->birthday);
        ChangeAddress::dispatchFromForm($user, $request);
        ChangePhone::dispatchFromForm($user, $request);
        ChangeStudy::dispatchFromForm($user, $request);
        ChangeParentsDetails::dispatchFromArray($user, $request->user(), $this->parentData);
        SetProfilePicture::dispatchFromForm($user, $request);

        // Fire event
        PotentialWasRegistered::dispatch(
            $user,
            $request->get('message'),
            $request->get('school'),
            $request->get('start_year'),
            $this->parentData['parent_email']
        );
    }
}
