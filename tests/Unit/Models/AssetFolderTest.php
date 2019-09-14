<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\AssetFolder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetFolderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(AssetFolder::class)->project());
    }

    /** @test */
    public function it_has_many_assets()
    {
        $this->assertInstanceOf(HasMany::class, app(AssetFolder::class)->assets());
    }

    /** @test */
    public function it_has_many_children()
    {
        $this->assertInstanceOf(HasMany::class, app(AssetFolder::class)->children());
    }

    /** @test */
    public function it_belongs_to_a_parent()
    {
        $this->assertInstanceOf(BelongsTo::class, app(AssetFolder::class)->parent());
    }
}
