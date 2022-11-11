<?php namespace GSVnet\Regions;

use App\Models\Region;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GSVnet\Core\BaseRepository;

class RegionsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Region $model)
    {
        $this->model = $model;
    }

    public function byId($id)
    {
        return Region::findOrFail($id);
    }

    public function former()
    {
        return Region::former()
            ->orderBy('end_date', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function all()
    {
        return Region::orderBy(\DB::raw('end_date IS NULL'), 'desc')
        ->orderBy('end_date', 'DESC')
        ->orderBy('name', 'ASC')
        ->get();
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
}