<?php

namespace Tests\Unit\Domains\Workflow\Models;

use Tests\TestCase;
use App\Domains\Workflow\Models\WorkflowStep;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkflowStepTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_workflow()
    {
        $this->assertInstanceOf(BelongsTo::class, app(WorkflowStep::class)->workflow());
    }
}
