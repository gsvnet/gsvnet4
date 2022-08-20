<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileAction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'at', 'action'];

    protected $casts = ['at' => 'datetime'];

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
