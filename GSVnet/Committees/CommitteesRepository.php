<?php namespace GSVnet\Committees;

use App\Models\User;
use App\Models\Committee;


class CommitteesRepository
{
    public function byUserOrderByRecent(User $user)
    {
        return $user->committees()->orderByRaw('-end_date ASC')->orderBy('end_date', 'ASC')->get();
    }

    public function all()
    {
        return Committee::all();
    }
}