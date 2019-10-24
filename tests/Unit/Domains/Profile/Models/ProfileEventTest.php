<?php

namespace Tests\Unit\Domains\Profile\Models;

use Tests\TestCase;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Models\ProfileEvent;
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

    /** @test */
    public function it_can_record_a_visted_page_event()
    {
        $profile = factory(Profile::class)->create();

        factory(ProfileEvent::class)->create([
            'profile_id' => $profile->local_id,
            'event_type' => 'other-event',
        ]);

        $event = ProfileEvent::recordVisitedPage($profile);

        $this->assertInstanceOf(ProfileEvent::class, $event);
    }
}
