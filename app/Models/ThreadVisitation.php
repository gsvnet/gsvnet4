<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThreadVisitation extends Model
{
    use HasFactory;

    protected $table = 'forum_thread_visitations';

    protected $fillable = ['user_id', 'thread_id', 'visited_at'];

    protected $casts = ['visited_at' => 'timestamp'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
