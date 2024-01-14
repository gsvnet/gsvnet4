<?php namespace GSVnet\Files\Labels;

use App\Models\Label;

class LabelsRepository
{
    /**
    * Get all labels.
    */
    public function all()
    {
        return Label::all();
    }
}