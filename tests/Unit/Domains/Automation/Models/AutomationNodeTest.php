<?php

namespace Tests\Unit\Domains\Automation\Models;

use Tests\TestCase;
use App\Domains\Automation\Models\AutomationNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationNodeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_automation()
    {
        $this->assertInstanceOf(BelongsTo::class, app(AutomationNode::class)->automation());
    }
}
