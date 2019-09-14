<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\CollectionEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollectionEntryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_collection()
    {
        $this->assertInstanceOf(BelongsTo::class, app(CollectionEntry::class)->collection());
    }
}
