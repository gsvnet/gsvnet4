<?php namespace GSVnet\Committees;

use App\Models\User;

class CommitteesRepository
{
    public function byUserOrderByRecent(User $user)
    {
        return $user->committees();
    }
}