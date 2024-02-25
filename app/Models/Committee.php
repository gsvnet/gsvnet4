<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Committee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopePublic($query) {
        return $query->wherePublic(true);
    }

    public function members(): BelongsToMany {
        return $this->belongsToMany(User::class)
            ->withPivot('id', 'start_date', 'end_date')
            ->using(CommitteeMembership::class);
    }

    public function users(): BelongsToMany {
        return $this->members();
    }

    public function activeMembers(): BelongsToMany {
        // Select all active members, i.e. for which the current date is
        // between the start and end date
        return $this->belongsToMany(User::class)
            ->where('committee_user.start_date', '<=', new \DateTime('now'))
            ->where(function($q) {
                return $q->where('committee_user.end_date', '>=', new \DateTime('now'))
                    ->orWhereNull('committee_user.end_date');
            })
            ->withPivot('start_date', 'end_date');
    }

    public function previousMembersTwoYear(): BelongsToMany {
        // Select all active members, i.e. for which the current date is
        // between the start and end date
        return $this->belongsToMany(User::class)
            ->where('committee_user.start_date', '<=', new \DateTime('now'))
            ->where(function($q) {
                $twoYearsAgo = now()->subYears(2); // Calculate the date from two years ago
                return $q->where('committee_user.end_date', '>=', $twoYearsAgo)
                    ->where('committee_user.end_date', '<', new \DateTime('now'));
            })           
            ->withPivot('start_date', 'end_date');
    }

    public function activeUsers(): BelongsToMany {
        return $this->activeMembers();
    }

}
