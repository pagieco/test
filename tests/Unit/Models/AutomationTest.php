<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Automation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Automation::class)->project());
    }

    /** @test */
    public function it_has_many_nodes()
    {
        $this->assertInstanceOf(HasMany::class, app(Automation::class)->nodes());
    }

    /** @test */
    public function it_can_insert_a_new_record()
    {
        $this->assertDatabaseHas('automations', [
            'id' => factory(Automation::class)->create()->id,
        ]);
    }
}
