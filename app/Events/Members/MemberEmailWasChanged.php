<?php namespace App\Events\Members;
      
use App\Models\User;

class MemberEmailWasChanged extends ProfileEvent
{
    protected $oldEmail;

    /**
     * MemberEmailWasChanged constructor.
     * @param User $member
     * @param User $manager
     * @param string $oldEmail
     */
    public function __construct(User $member, User $manager, $oldEmail)
    {
        parent::__construct($member, $manager);        
        $this->oldEmail = $oldEmail;
    }

    /**
     * @return string
     */
    public function getOldEmail()
    {
        return $this->oldEmail;
    }
}
