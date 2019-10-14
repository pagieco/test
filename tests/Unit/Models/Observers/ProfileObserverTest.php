<?php

namespace Tests\Unit\Models\Observers;

use Tests\TestCase;
use App\Models\Profile;
use App\Mail\ProfileConsentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_profile_id_when_the_creating_event_is_triggered()
    {
        $profile = factory(Profile::class)->create([
            'profile_id' => null,
        ]);

        $this->assertNotNull($profile->profile_id);
    }

    /** @test */
    public function it_sets_the_first_seen_at_attribute_when_the_creating_event_is_triggered()
    {
        $profile = factory(Profile::class)->create();

        $this->assertNotNull($profile->first_seen_at);
    }

    /** @test */
    public function it_sends_a_consent_confirmation_email_when_the_created_event_is_triggered()
    {
        Mail::fake();

        $profile = factory(Profile::class)->create();

        Mail::assertQueued(ProfileConsentMail::class, function (ProfileConsentMail $mail) use ($profile) {
            return $mail->profile->email === $profile->email;
        });
    }
}
