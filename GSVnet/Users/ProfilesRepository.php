<?php namespace GSVnet\Users;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use GSVnet\Core\BaseRepository;
use Config;

class ProfilesRepository extends BaseRepository
{
    protected $model;

    public function __construct(UserProfile $model)
    {
        $this->model = $model;
    }

    public function byId($id)
    {
        return UserProfile::findOrFail($id);
    }

    public function searchAndPaginate($search, $region = null, $yearGroup = null, $type = 2, $perPage = 20)
    {
        return $this->search($search, $region, $yearGroup, $type)->paginate($perPage);
    }

    public function search($keyword = '', $region = null, $yearGroup = null, $type = 2)
    {
        $query = UserProfile::with('user', 'yearGroup', 'regions')
        ->join('users', 'users.id', '=', 'user_profiles.user_id')
        ->leftJoin('region_user_profile', 'user_profiles.id', '=', 'region_user_profile.user_profile_id')
        ->leftJoin('regions', 'region_user_profile.region_id', '=', 'regions.id')
        ->groupBy('user_profiles.id');

        if(is_array($type))
            $query->whereIn('users.type', $type);
        else
            $query->where('users.type', '=', $type);
        
        $query->orderBy('users.lastname')->orderBy('users.firstname');

        if ( ! empty($keyword))
        {
            $words = explode(' ', $keyword);
            $query->searchName($words);
        }

        if (isset($region))
        $query->where('regions.id', '=', $region);

        if (isset($yearGroup))
            $query->where('year_group_id', '=', $yearGroup);

        return $query;
    }
}