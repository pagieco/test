<?php

namespace Tests\Unit\Domains\Workflow\Models;

use Tests\TestCase;
use App\Domains\Workflow\Models\Workflow;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Workflow::class)->project());
    }

    /** @test */
    public function it_has_many_steps()
    {
        $this->assertInstanceOf(HasMany::class, app(Workflow::class)->steps());
    }
}
