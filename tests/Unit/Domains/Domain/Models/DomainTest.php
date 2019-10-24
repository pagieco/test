<?php

namespace Tests\Unit\Domains\Domain\Models;

use Tests\TestCase;
use App\Domains\Domain\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Domain::class)->project());
    }
}
