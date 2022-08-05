<?php

namespace GSVnet\Forum;

use App\Http\Controllers\ThreadController;
use Illuminate\Database\Eloquent\Collection;

class TagCollection extends Collection {
    public function getTagList(): string {
        $tagLinks = [];

        foreach ($this->items as $item) {
            $tagLinks[] = action([ThreadController::class, 'getIndex'], ['tags' => $item->slug]);
        }

        return implode(', ', $tagLinks);
    }
}
