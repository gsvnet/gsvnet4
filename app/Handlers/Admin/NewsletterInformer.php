<?php namespace App\Handlers\Admin;

use App\Events\Members\MembershipStatusWasChanged;
use App\Events\Members\ProfileEvent;
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Newsletters\NewsletterList;
use GSVnet\Users\UserTransformer;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterInformer implements ShouldQueue
{
    /**
     * @var NewsletterList
     */
    protected $list;

    /**
     * @var UserTransformer
     */
    private $transformer;

    /**
     * NewsletterInformer constructor.
     * @param NewsletterList $newsletterList
     * @param UserTransformer $transformer
     */
    public function __construct(NewsletterList $newsletterList, UserTransformer $transformer)
    {
        $this->list = $newsletterList;
        $this->transformer = $transformer;
    }

    public function handle(ProfileEvent $event)
    {
        $user = $event->getUser();

        $listMemberTypes = [
            UserTypeEnum::MEMBER, 
            UserTypeEnum::REUNIST, 
            UserTypeEnum::EXMEMBER
        ];

        // Remove from old mailing lists if necessary
        if ($event instanceof MembershipStatusWasChanged) {
            if (in_array($event->getOldStatus(), $listMemberTypes))
                $this->list->unsubscribeFrom($event->getOldStatus(), $user->email);
        }

        // (Re-)add to mailing lists
        // TODO: Add proper error handling
        if ($user->isMemberOrReunist() && $user->profile && $user->profile->alive) {
            $data = $this->transformer->newsletterSubscribeInformation($user);
            $this->list->subscribeTo($user->type, $user->email, $data);
        }
    }
}
