<?php

namespace App\Models;

use Carbon\Carbon;
use GSVnet\Events\EventType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function type(): Attribute {
        return Attribute::make(
            get: fn($typeInt) => EventType::from($typeInt),
            set: fn($typeEnum) => $typeEnum->value
        );
    }

    public function scopePublic($query) {
        return $query->wherePublic(true);
    }

    public function scopePublished($query, $published = true) {
        return $query->wherePublished($published);
    }

    public function generateNewSlug(): string {
        $i = 0;

        while ($this->getCountBySlug($this->generateSlugByIncrementer($i)) > 0) {
            $i++;
        }

        return $this->generateSlugByIncrementer($i);
    }

    private function getCountBySlug($slug) {
        $date = Carbon::parse($this->start_date);
        $start = $date->format('Y-m-01');
        $end = $date->format('Y-m-t');
        $query = static::where('slug', '=', $slug)
            ->where('start_date', '<=', $end)
            ->where('start_date', '>=', $start);

        if ($this->exists) {
            $query->where('id', '!=', $this->id);
        }

        return $query->count();
    }

    private function generateSlugByIncrementer($i): string {
        if ($i == 0) {
            $append = '';
        } else {
            $append = '-' . $i;
        }

        return Str::slug($this->title . $append);
    }
}
