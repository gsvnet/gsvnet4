<?php namespace GSVnet\Regions;

use App\Models\Region;

class RegionsRepository
{
    public function former()
    {
        return Region::former()
            ->orderBy('end_date', 'DESC')
            ->orderBy('name', 'ASC')
            ->get();
    }
}