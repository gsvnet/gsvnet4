<?php namespace GSVnet\Newsletters;
      
use MailchimpMarketing\ApiClient;

class MailchimpApiClient extends ApiClient 
{
    public function __construct() {
        parent::__construct();

        $this->setConfig([
            'apiKey' => config('mailchimp.key'),
            'server' => config('mailchimp.server')
        ]);
    }
}
