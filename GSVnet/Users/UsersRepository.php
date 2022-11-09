<?php namespace GSVnet\Users;

use App\Models\User;
use GSVnet\Core\BaseRepository;

class UsersRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    public function byId($id)
    {
        return User::findOrFail($id);
    }

    public function isEmailAdressTaken($email, $id)
    {
        return User::where('email', '=', $email)->where('id', '<>',$id)->exists();
    }
}