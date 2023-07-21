<?php

namespace App\Jobs;

use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var array $data data from user creation form */
    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->data['password'] = bcrypt($this->data['password']);
        $this->data['type'] = UserTypeEnum::from($this->data['type']);
        $this->data['approved'] = true;

        User::create($this->data);
    }
}
