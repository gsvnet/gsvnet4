<?php

namespace App\Models;

use GSVnet\Core\Enums\GenderEnum;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laracasts\Presenter\PresentableTrait;

class UserProfile extends Model
{
    use HasFactory, PresentableTrait;

    /**
     * Path to presenter class.
     * 
     * @var string
     */
    protected $presenter = 'GSVnet\Users\Profiles\ProfilePresenter';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'gender' => GenderEnum::class,
        'birthday' => 'date:Carbon'
    ];

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
                $q->where('type', UserTypeEnum::MEMBER->value);
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
