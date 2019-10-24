<?php

namespace Tests\Unit\Domains\Collection\Models;

use Tests\TestCase;
use App\Domains\Collection\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    protected $model = Collection::class;

    /** @test */
    public function it_has_many_entries()
    {
        $this->assertInstanceOf(HasMany::class, app($this->model)->entries());
    }

    /** @test */
    public function it_has_many_fields()
    {
        $this->assertInstanceOf(HasMany::class, app($this->model)->fields());
    }
}
