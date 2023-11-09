<?php namespace GSVnet\Users\ValueObjects;

use Carbon\Carbon;

class NullableDate 
{
    private $date = null;

    function __construct($date = null)
    {
        if (is_null($date)) {
            return;
        }

        $this->date = Carbon::createFromFormat('Y-m-d', $date);
    }

    public function getDate()
    {
        return $this->date;
    }

    public function asString()
    {
        return $this->date ? $this->date->format('Y-m-d') : null;
    }
}