<?php namespace App\Handlers\Users;

use App\Events\Users\UserWasRegistered;
use App\Mail\RegisteredAdminEmail;
use App\Mail\WelcomeEmail;
use App\Mail\WelcomeReunistEmail;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Support\Facades\Mail;

class UserMailer {

    public function sendWelcomeEmail(UserWasRegistered $event)
    {
        $user = $event->user;
        $data = compact('user');

        // If the user is already approved, we assume an administrator has registered them
        // and we'll not inform anybody
        if($user->approved)
            return;

        Mail::to($user)->send(new WelcomeEmail($user));

        $adminEmail = config('gsvnet.email.admin');
        Mail::to($adminEmail)->send(new RegisteredAdminEmail());
    }

    public function notifyReunist(UserWasRegistered $event)
    {
        $user = $event->user;
        if($user->type != UserTypeEnum::REUNIST)
            return;

        Mail::to($user)->send(new WelcomeReunistEmail($user));
    }
}