<?php

namespace Tests\Unit\Domains\Collection\Models;

use Tests\TestCase;
use App\Domains\Collection\Models\CollectionField;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionFieldTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_collection()
    {
        $this->assertInstanceOf(BelongsTo::class, app(CollectionField::class)->collection());
    }
}
