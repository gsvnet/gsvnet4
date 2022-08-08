<?php

namespace App\Models;

use GSVnet\Forum\LikableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'forum_replies';
    protected $fillable = ['body', 'author_id', 'thread_id'];
    protected $with = ['author'];

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function thread(): BelongsTo {
        return $this->belongsTo(Thread::class);
    }

    public function likers(): BelongsToMany {
        return $this->belongsToMany(User::class, 'likes');
    }
}
