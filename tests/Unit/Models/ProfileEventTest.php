<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\ProfileEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_profile()
    {
        $this->assertInstanceOf(BelongsTo::class, app(ProfileEvent::class)->profile());
    }
}
