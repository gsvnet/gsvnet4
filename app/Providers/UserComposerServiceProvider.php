<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use GSVnet\Users\UsersRepository;

class UserComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $usersRepository = app(UsersRepository::class);
                
                $activeUserPostCount = $usersRepository->postsAllTimeUser($user->id);
                $activeUserTopicCount = $usersRepository->topicsAllTimeUser($user->id);
                
                if ($activeUserPostCount == null){
                    $activeUserPostCount = 0;
                }
                
                if ($activeUserTopicCount == null){
                    $activeUserTopicCount = 0;
                }

                $view->with('user', $user)
                    ->with('activeUserPostCount', $activeUserPostCount)
                    ->with('activeUserTopicCount', $activeUserTopicCount);
            }
        });
    }
}
