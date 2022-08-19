<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as F;

// TODO: Make event listener that deletes associated file on disk when model instance is deleted

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file_path', 'published'];

    protected $appends = ['size', 'type'];

    protected function size(): Attribute {
        return Attribute::make(
            get: fn() => $this->readable_size(filesize($this->fileLocation()))
        );
    }

    protected function type(): Attribute {
        return Attribute::make(
            get: fn() => '.' . F::extension($this->fileLocation())
        );
    }

    public function labels(): BelongsToMany {
        return $this->belongsToMany(Label::class);
    }

    public function scopePublished($query, $published = true) {
        return $query->wherePublished($published);
    }

    public function scopeWithLabels($query, array $labels = []) {
        $count = count($labels);
        // Return original query when we have no restriction on the labels
        if ($count == 0) { return $query; }

        // Get the ids of files which belong to all the specified labels
        $file_ids = DB::table('file_label')
            ->whereIn('label_id', $labels)
            ->groupBy('file_id')
            ->havingRaw('count(*) = ' . $count)
            ->pluck('file_id');

        if (empty($file_ids))
            return $query->where(DB::raw('false'));

        // Return all files with the found ids
        return $query->whereIn('id', $file_ids);
    }

    public function scopeSearch($query, $search) {
        return $query->whereRaw("MATCH(name) AGAINST(? IN BOOLEAN MODE)", [$search]);
    }

    public function fileLocation(): string {
        return storage_path($this->file_path);
    }

    private function readable_size($size): string {
        $tmp = $size;
        if ($tmp >= 0 && $tmp < 1024) {
            $readableSize = $tmp . " bytes";
        } elseif ($tmp >=1024 && $tmp < 1048576) { // less than 1 MB
            $tmp = $tmp / 1024;
            $readableSize = round($tmp) . " KB";
        } elseif ($tmp >=1048576 && $tmp < 10485760) { // more than 1 MB, but less than 10
            $tmp = $tmp / 1048576;
            $readableSize = round($tmp, 1) . " MB";
        } else { // larger than 10 MB
            $tmp = $tmp / (1024 * 1024 * 1024);
            $readableSize = round($tmp, 1) . " GB";
            // } else {
            //     $readableSize = 'groter dan je moeder';
        }
        return $readableSize;
    }
}
