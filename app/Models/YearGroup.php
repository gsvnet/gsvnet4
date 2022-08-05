<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YearGroup extends Model
{
    use HasFactory;

    public function userProfiles(): HasMany {
        return $this->hasMany(UserProfile::class);
    }
}
