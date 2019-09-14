<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Asset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Asset::class)->project());
    }

    /** @test */
    public function it_belongs_to_a_folder()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Asset::class)->folder());
    }
}
