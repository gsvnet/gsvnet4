<?php

namespace App\Models;

use GSVnet\Forum\LikableTrait;
use GSVnet\Forum\VisibilityLevel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LikableTrait;

    protected $table = 'forum_threads';
    protected $fillable = ['subject', 'body', 'author_id', 'slug', 'visibility'];
    protected $with = ['author'];

    protected function visibility(): Attribute {
        return Attribute::make(
            get: fn($visibilityInt) => VisibilityLevel::from($visibilityInt),
            set: fn($visibilityEnum) => $visibilityEnum->value
        );
    }

    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function replies(): HasMany {
        return $this->hasMany(Reply::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class,
            'tagged_items', 'thread_id', 'tag_id');
    }

    public function visitations(): HasMany {
        return $this->hasMany(ThreadVisitation::class);
    }

    public function mostRecentReply(): BelongsTo {
        return $this->belongsTo(Reply::class, 'most_recent_reply_id');
    }

    public function getTags() {
        return $this->tags->pluck('slug');
    }

    public function setTags(array $tagIds) {
        $this->tags()->sync($tagIds);
    }

    public function hasTag($tagId) {
        return $this->tags->contains($tagId);
    }

    public function scopePublic($query) {
        return $query->whereVisibility(VisibilityLevel::PUBLIC->value);
    }

    public function getReplyIndex($replyId): int {
        return $this->replies()->where('id', '<', $replyId)->count();
    }

    public function getReplyPageNumber($replyId, $repliesPerPage): int {
        return (int)($this->getReplyIndex($replyId) / $repliesPerPage + 1);
    }
}
