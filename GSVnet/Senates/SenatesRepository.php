<?php namespace GSVnet\Senates;

use App\Models\Senate;


class SenatesRepository
{
    public function all()
    {
        return Senate::orderBy('start_date', 'DESC')->get();
    }

    public function byId($id)
    {
        return Senate::findOrFail($id);
    }
}