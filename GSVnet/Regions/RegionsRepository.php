<?php namespace GSVnet\Regions;

use App\Models\Region;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GSVnet\Core\BaseRepository;

class RegionsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Region $model)
    {
        $this->model = $model;
    }

    public function byId($id): Region
    {
        return Region::findOrFail($id);
    }

    public function byIds(Array $ids): Collection
    {
        return Region::whereIn('id', $ids)->get();
    }

    public function current(): Collection
    {
        return Region::current()
                    ->orderBy('end_date', 'DESC')
                    ->orderBy('name', 'ASC')
                    ->get();
    }

    public function former(): Collection
    {
        return Region::former()
            ->orderBy('end_date', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();
    }

    public function all(): Collection
    {
        return Region::orderBy(\DB::raw('end_date IS NULL'), 'desc')
                ->orderBy('end_date', 'DESC')
                ->orderBy('name', 'ASC')
                ->get();
    }

    public function exists($id): bool
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