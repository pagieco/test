<?php

namespace Tests\Unit\Domains\Page\Observers;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Domains\Page\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_slug_attribute_when_the_creating_event_is_triggered_and_the_slug_isnt_already_filled_in()
    {
        $page = factory(Page::class)->create([
            'slug' => null,
        ]);

        $this->assertEquals($page->slug, Str::slug($page->name));
    }
}
