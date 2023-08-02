<?php

namespace App\Providers;

use GSVnet\Newsletters\MailchimpApiClient;
use GSVnet\Newsletters\MailchimpNewsletterList;
use GSVnet\Newsletters\NewsletterList;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class NewsletterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(NewsletterList::class, function(Application $app) {
            return new MailchimpNewsletterList($app->make(MailchimpApiClient::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
