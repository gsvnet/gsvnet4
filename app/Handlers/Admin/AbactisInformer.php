<?php namespace App\Handlers\Admin;

use App\Events\Members\MemberFileWasCreated;
use App\Mail\MemberFileEmail;
use Illuminate\Support\Facades\Mail;

class AbactisInformer
{
    public function handle(MemberFileWasCreated $event)
    {
        $abactis = config('gsvnet.email.senate');

        Mail::to($abactis)->send(new MemberFileEmail($event));
    }
}