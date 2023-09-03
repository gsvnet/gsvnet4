<?php namespace App\Handlers\Potentials;

use App\Events\Potentials\PotentialWasAccepted;
use App\Events\Potentials\PotentialWasRegistered;
use App\Mail\JoinedWelcomeEmail;
use App\Mail\PotentialAcceptedEmail;
use App\Mail\PotentialAppliedEmail;
use Illuminate\Support\Facades\Mail;

class PotentialMailer {
    public function sendWelcomeEmail(PotentialWasRegistered $event)
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

    public function sendActivatedEmail(PotentialWasAccepted $event)
    {
        $user = $event->user;
        Mail::to($user)->send(new PotentialAcceptedEmail($user));
    }
}