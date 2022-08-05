<?php

namespace App\Models;

use GSVnet\Forum\TagCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table = 'tags';
    protected $guarded = [];

    public function newCollection(array $models = []): TagCollection {
        return new TagCollection($models);
    }
}
