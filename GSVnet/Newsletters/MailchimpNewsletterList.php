<?php namespace GSVnet\Newsletters;
      
use GSVnet\Core\Enums\UserTypeEnum;
use GSVnet\Core\Exceptions\ListNotFoundException;
use MailchimpMarketing\ApiClient;

class MailchimpNewsletterList implements NewsletterList
{
    /**
     * Mapping from list name (or application list id) to Mailchimp list id.
     * @var array
     */
    protected $lists = [];

    /**
     * Mailchimp client.
     * @var ApiClient
     */
    protected ApiClient $client;

    public function __construct(ApiClient $client) {
        $this->client = $client;
        $this->lists = config('mailchimp.lists');
    }

    /**
     * Converts listName to its backed enum value. Throws an exception if the list does not exist.
     * @param UserTypeEnum $listName
     * @throws ListNotFoundException
     * @return int
     */
    private function checkListName(UserTypeEnum $listName) {
        $listName = $listName->value;
        
        if (!array_key_exists($listName, $this->lists))
            throw new ListNotFoundException("List $listName was not found");

        return $listName;
    }

    public function subscribeTo(UserTypeEnum $listName, $email, $merge_fields) {
        $listName = $this->checkListName($listName);

        return $this->client->lists->addListMember(
            $this->lists[$listName],
            [
                'email_address' => $email,
                'status' => 'subscribed',
                'email_type' => 'html',
                'merge_fields' => $merge_fields
            ]
        );
    }

    public function unsubscribeFrom(UserTypeEnum $listName, $email) {
        $listName = $this->checkListName($listName);
        
        return $this->client->lists->deleteListMember(
            $this->lists[$listName],
            md5($email)
        );
    }

    public function batchSubscribeTo(UserTypeEnum $listName, $batch) {
        $listName = $this->checkListName($listName);

        $operations = array_map(function($subscriber) use ($listName) {
            return [
                'method' => 'POST',
                'path' => "/lists/$listName/members",
                'body' => json_encode([
                    'email_address' => $subscriber['email'],
                    'status' => 'subscribed',
                    'email_type' => 'html',
                    'merge_fields' => $subscriber['merge_fields']
                ])
            ];
        }, $batch);

        return $this->client->batches->start($operations);
    }

    public function batchUnsubscribeFrom(UserTypeEnum $listName, $batch) {
        $listName = $this->checkListName($listName);

        $operations = array_map(function($email) use ($listName) {
            $hash = md5($email);
            
            return [
                'method' => 'DELETE',
                'path' => "/lists/$listName/members/$hash"
            ];
        }, $batch);

        return $this->client->batches->start($operations);
    }
}