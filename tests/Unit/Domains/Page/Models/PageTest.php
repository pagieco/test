<?php

namespace Tests\Unit\Domains\Page\Models;

use Tests\TestCase;
use App\Domains\Page\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Page::class)->project());
    }

    /** @test */
    public function it_belongs_to_a_domain()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Page::class)->domain());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('pages', [
            'local_id' => factory(Page::class)->create()->local_id,
        ]);
    }
}
