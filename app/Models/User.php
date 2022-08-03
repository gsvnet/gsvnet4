<?php

namespace App\Models;

use GSVnet\Users\UserType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property mixed $type
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'middlename',
        'lastname',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function type(): Attribute {
        return Attribute::make(
            get: fn($typeInt) => UserType::from($typeInt),
            set: fn($typeEnum) => $typeEnum->value
        );
    }

    public function committees(): BelongsToMany {
        return $this->belongsToMany(Committee::class)
            ->withPivot('start_date', 'end_date')
            ->withTimestamps();
    }

    public function senates(): BelongsToMany {
        return $this->belongsToMany(Senate::class)
            ->withPivot('function')
            ->withTimestamps();
    }

    public function activeSenate(): BelongsToMany {
        return $this->belongsToMany(Senate::class)
            ->where('start_date', '<=', new \DateTime('now'))
            ->where(function($q) {
                return $q->where('end_date', '>=', new \DateTime('now'))
                    ->orWhereNull('end_date');
            })
            ->withPivot('function');
    }

    public function profile(): HasOne {
        return $this->hasOne(UserProfile::class);
    }

    public function profileChanges(): HasMany {
        return $this->hasMany(ProfileAction::class, 'user_id', 'id');
    }

    public function replies(): HasMany {
        return $this->hasMany(Reply::class);
    }

    public function threads(): HasMany {
        return $this->hasMany(Thread::class);
    }

    public function parents(): BelongsToMany {
        return $this->belongsToMany(self::class, 'family_relations', 'child_id', 'parent_id');
    }

    public function children(): BelongsToMany {
        return $this->belongsToMany(self::class, 'family_relations', 'parent_id', 'child_id');
    }

    public function isMember(): bool {
        return $this->type == UserType::MEMBER;
    }

    public function wasOrIsMember(): bool {
        return in_array($this->type, [UserType::MEMBER, UserType::REUNIST, UserType::EXMEMBER]);
    }

    public function isFormerMember(): bool {
        return $this->type == UserType::REUNIST || $this->type == UserType::EXMEMBER;
    }

    public function isMemberOrReunist(): bool {
        return $this->type == UserType::MEMBER || $this->type == UserType::REUNIST;
    }

    public function isPotential(): bool {
        return $this->type == UserType::POTENTIAL;
    }

    public function isReunist(): bool {
        return $this->type == UserType::REUNIST;
    }

    public function isExMember(): bool {
        return $this->type == UserType::EXMEMBER;
    }

    public function isVisitor(): bool {
        return $this->type == UserType::VISITOR;
    }

    public function isVerified(): bool {
        return $this->hasVerifiedEmail();
    }

    public function activeCommittees(): belongsToMany {
        return $this->belongsToMany(Committee::class)
            ->where('committee_user.start_date', '<=', new \DateTime('now'))
            ->where(function($q) {
                return $q->where('committee_user.end_date', '>=', new \DateTime('now'))
                    ->orWhereNull('committee_user.end_date');
            })
            ->withPivot('start_date', 'end_date');
    }
}
