<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use App\Models\ProfileEvent;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileEventObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_occurred_at_attribute_when_creating_a_new_Event()
    {
        $event = factory(ProfileEvent::class)->create();

        $this->assertInstanceOf(Carbon::class, $event->occurred_at);
    }
}
