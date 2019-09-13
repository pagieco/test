<?php

namespace App\Models\Observers;

use App\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{
    public function creating(Page $page): void
    {
        if (! $page->slug) {
            $page->setAttribute('slug', Str::slug($page->name));
        }
    }
}
