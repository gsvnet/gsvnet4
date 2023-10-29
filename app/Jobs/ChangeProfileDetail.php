<?php

namespace App\Jobs;

use App\Models\User;
use GSVnet\Core\Exceptions\UnexpectedTypeException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Bus\PendingDispatch;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class ChangeProfileDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $member;
    protected User $manager;

    // /**
    //  * Create a new job instance. 
    //  * Instantiate with {User $member, Request $request} or {User $member, User $manager, array $data}.
    //  * @param User $member
    //  * @param Request|User $request_or_manager
    //  * @param array|null $data
    //  */
    // public function __construct(User $member, ...$args) {
    //     $this->member = $member;

    //     if ($args[0] instanceof Request) {
    //         $request = $args[0];
    //         $this->manager = $request->user();
    //         $this->data = $request->all();
    //     } elseif ($args[0] instanceof User && is_array($args[1])) {
    //         $this->manager = $args[0];
    //         $this->data = $args[1];
    //     } else {
    //         throw new UnexpectedTypeException("Unexpected parameter types. Should be {User, User, array} or {User, Request}");
    //     }
    // }

    abstract static function dispatchFromForm(User $member, Request $request): PendingDispatch;
}
