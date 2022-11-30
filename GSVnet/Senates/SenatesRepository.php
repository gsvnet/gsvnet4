<?php namespace GSVnet\Senates;

use App\Models\Senate;


class SenatesRepository
{
    public function all()
    {
        return Senate::all();
    }
}