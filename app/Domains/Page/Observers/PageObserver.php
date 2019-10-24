<?php

namespace App\Domains\Page\Observers;

use Illuminate\Support\Str;
use App\Domains\Page\Models\Page;

class PageObserver
{
    /**
     * Listen to the page model "creating" event.
     *
     * @param  \App\Domains\Page\Models\Page $page
     * @return void
     */
    public function creating(Page $page): void
    {
        if (! $page->slug) {
            $page->setAttribute('slug', Str::slug($page->name));
        }
    }
}
