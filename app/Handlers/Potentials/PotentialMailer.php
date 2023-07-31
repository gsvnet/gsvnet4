<?php namespace App\Handlers\Potentials;

use App\Events\Potentials\PotentialSignedUp;
use App\Mail\JoinedWelcomeEmail;
use App\Mail\PotentialAppliedEmail;
use Illuminate\Support\Facades\Mail;

class PotentialMailer {
    public function sendWelcomeMail(PotentialSignedUp $event)
    {
        $user = $event->user;

        Mail::to($user)->send(new JoinedWelcomeEmail($user));

        $novcie = config('gsvnet.email.membership');
        $prescie = config('gsvnet.email.prescie');
        $webcie = config('gsvnet.email.admin');

        $profile = $user->profile;

        Mail::to($novcie)
            ->cc([$prescie, $webcie])
            ->send(new PotentialAppliedEmail($user, $profile, $event));
    }
}