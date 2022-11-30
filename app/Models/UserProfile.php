<?php

namespace App\Models;

use GSVnet\Users\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserProfile extends Model
{
    use HasFactory;

    // Mass assignment should be done carefully because of this
    protected $guarded = [];

    public function scopeSearchName($query, $words) {
        foreach ($words as $key) {
            $query = $query->where(function($q) use ($key) {
                $q->orwhere('firstname', 'like', $key . '%')
                    ->orwhere('middlename', 'like', $key . '%')
                    ->orwhere('lastname', 'like', $key . '%');
            });
        }

        return $query;
    }

    public function inmates() {
        return $this->whereRaw("REPLACE(`address`, ' ' ,'') LIKE ?",
                               [str_replace(' ', '', $this->address)])
            ->where('user_id', '!=', $this->user_id)
            ->whereHas('user', function($q){
                $q->where('type', UserType::MEMBER->value);
            })
            ->get();
    }

    public function yearGroup(): BelongsTo {
        return $this->belongsTo(YearGroup::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function regions(): BelongsToMany {
        return $this->belongsToMany(Region::class)
            ->orderBy(\DB::raw('end_date IS NULL'), 'desc')
            ->orderBy('end_date', 'desc')
            ->orderBy('name', 'asc');
    }
}
