<?php

namespace App\Models\Observers;

use App\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{
    /**
     * Listen to the page model "creating" event.
     *
     * @param  \App\Models\Page $page
     * @return void
     */
    public function creating(Page $page): void
    {
        if (! $page->slug) {
            $page->setAttribute('slug', Str::slug($page->name));
        }
    }
}
