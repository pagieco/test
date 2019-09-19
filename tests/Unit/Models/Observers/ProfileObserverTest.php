<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_profile_idd_when_the_creating_event_is_triggered()
    {
        $profile = factory(Profile::class)->create([
            'profile_id' => null,
        ]);

        $this->assertNotNull($profile->profile_id);
    }
}
