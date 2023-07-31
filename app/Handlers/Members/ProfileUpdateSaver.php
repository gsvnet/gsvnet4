<?php namespace App\Handlers\Members;

use App\Events\Members\ProfileEvent;
use App\Models\ProfileAction;
use GSVnet\Users\ProfileActions\ProfileActionsRepository;
use GSVnet\Users\UsersRepository;

class ProfileUpdateSaver
{
    function __construct(
        private ProfileActionsRepository $actions, 
        private UsersRepository $users
    ) {}

    public function changedProfile(ProfileEvent $event)
    {
        $name = get_class($event);
        $action = ProfileAction::createForUser(
            $event->getUser()->id,
            $event->getAt(),
            $name
        );
        $this->actions->save($action);
    }

    public function tookAccountInUse(ProfileEvent $event)
    {
        $member = $event->getUser();
        $member->verified = true;
        $this->users->save($member);
    }
}