<?php

// TODO: Fix Illegal offset type

use GSVnet\Core\Enums\UserTypeEnum;

return [
    'key' => env('MAILCHIMP_APIKEY'),
    'server' => env('MAILCHIMP_SERVER'),
    'lists' => [
        UserTypeEnum::MEMBER->value => env('MAILCHIMP_MEMBERS', 'c5f9a07ee4'),
        UserTypeEnum::REUNIST->value => env('MAILCHIMP_FORMERMEMBERS', 'f844adabde')
    ]
];