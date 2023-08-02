<?php namespace GSVnet\Newsletters;

use GSVnet\Core\Enums\UserTypeEnum;

interface NewsletterList {
    /**
     * @param UserTypeEnum $listName
     * @param string $email
     * @param array<string, mixed> $merge_fields
     * @return mixed
     */
    public function subscribeTo(UserTypeEnum $listName, $email, $merge_fields);

    /**
     * @param UserTypeEnum $list
     * @param string $email
     * @return mixed
     */
    public function unsubscribeFrom(UserTypeEnum $list, $email);

    /**
     * Subscribe multiple members.
     * 
     * $batch expects an array of dictionaries, each with an entry for 'email' and 'merge_vars'.
     * 
     * @param UserTypeEnum $listname
     * @param array<array<string, mixed>> $batch
     * @return mixed
     */
    public function batchSubscribeTo(UserTypeEnum $listname, $batch);

    /**
     * Unsubscribe (archive) multiple subscribers.
     * 
     * $batch expects an array of email addresses.
     * 
     * @param UserTypeEnum $listname
     * @param array<string> $batch
     * @return mixed
     */
    public function batchUnsubscribeFrom(UserTypeEnum $listname, $batch);
} 