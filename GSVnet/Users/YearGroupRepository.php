<?php namespace GSVnet\Users;

use App\Models\YearGroup;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GSVnet\Core\BaseRepository;

class YearGroupRepository extends BaseRepository
{
    protected $model;

    public function __construct(YearGroup $model)
    {
        $this->model = $model;
    }
    
    public function byId($id)
    {
        return YearGroup::findOrFail($id);
    }

    public function exists($id)
    {
        try
        {
            $this->byId($id);
        }
        catch (ModelNotFoundException $e)
        {
            return false;
        }
        return true;
    }

    public function all()
    {
        return YearGroup::orderBy('year', 'DESC')->get();
    }
}