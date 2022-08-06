<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Label extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function files(): BelongsToMany {
        return $this->belongsToMany(File::class);
    }

    public function __toString() {
        return $this->name;
    }
}
