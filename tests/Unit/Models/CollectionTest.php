<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Collection::class)->project());
    }

    /** @test */
    public function it_has_many_entries()
    {
        $this->assertInstanceOf(HasMany::class, app(Collection::class)->entries());
    }

    /** @test */
    public function it_has_many_fields()
    {
        $this->assertInstanceOf(HasMany::class, app(Collection::class)->fields());
    }
}
