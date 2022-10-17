<?php namespace GSVnet\Users;

use App\Models\User;

class UsersRepository
{
    
    public function byId($id)
    {
        return User::findOrFail($id);
    }
}