<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Collection;
use Tests\RefreshCollections;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\EmbedsMany;

class CollectionTest extends TestCase
{
    use RefreshCollections;

    protected $model = Collection::class;

    /** @test */
    public function it_has_many_entries()
    {
        $this->assertInstanceOf(HasMany::class, app($this->model)->entries());
    }

    /** @test */
    public function it_embeds_many_fields()
    {
        $this->assertInstanceOf(EmbedsMany::class, app($this->model)->fields());
    }
}
