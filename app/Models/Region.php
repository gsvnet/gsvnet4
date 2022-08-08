<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function members(): BelongsToMany {
        return $this->belongsToMany(UserProfile::class);
    }

    public function scopeCurrent($query) {
        return $query->whereNull('end_date');
    }

    public function scopeFormer($query) {
        return $query->whereNotNull('end_date');
    }
}
