<?php

namespace App\Models;

use DateTime;
use GSVnet\Users\ProfileActions\ProfileActionPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;

class ProfileAction extends Model
{
    use HasFactory, PresentableTrait;

    public $timestamps = false;

    protected $fillable = ['user_id', 'at', 'action'];

    protected $casts = ['at' => 'datetime'];

    protected $presenter = ProfileActionPresenter::class;

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    static function createForUser($id, DateTime $moment, $action): static {
        return new static([
            'user_id' => $id,
            'at' => $moment,
            'action' => $action
        ]);
    }
}
