<?php namespace App\Events\Members;

use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;

class MembershipStatusWasChanged extends ProfileEvent
{

    /**
     * Previous member type.
     * @var UserTypeEnum
     */
    private $oldStatus;

    public function __construct(User $user, User $manager, UserTypeEnum $oldStatus)
    {
        parent::__construct($user, $manager);
        $this->oldStatus = $oldStatus;
    }

    public function getOldStatus(): UserTypeEnum
    {
        return $this->oldStatus;
    }
}