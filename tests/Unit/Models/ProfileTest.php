<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Profile;
use App\Models\ProfileEvent;
use Illuminate\Http\Request;
use App\Models\Enums\ProfileEventType;
use App\Exceptions\InvalidProfileTypeException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        $this->assertInstanceOf(BelongsTo::class, app(Profile::class)->project());
    }

    /** @test */
    public function it_has_many_events()
    {
        $this->assertInstanceOf(HasMany::class, app(Profile::class)->events());
    }

    /** @test */
    public function it_can_give_consent()
    {
        $profile = factory(Profile::class)->create();

        $this->assertFalse($profile->has_consented);

        $profile->giveConsent();

        $this->assertTrue($profile->has_consented);
    }

    /** @test */
    public function it_can_record_a_new_profile_event()
    {
        $profile = factory(Profile::class)->create();

        $profile->recordEvent(ProfileEventType::VisitedPage, [
            'test' => 'event-data',
        ]);

        $this->assertCount(1, $profile->events);
        $this->assertNotNull($profile->events->first()->data);
    }

    /** @test */
    public function it_throws_an_invalid_profile_type_exception_when_recording_with_an_invalid_profile_type()
    {
        $this->expectException(InvalidProfileTypeException::class);

        $profile = factory(Profile::class)->create();

        $profile->recordEvent('invalid-event', []);
    }

    /** @test */
    public function it_can_record_an_event()
    {
        $profile = factory(Profile::class)->create();

        $this->assertCount(0, $profile->events);

        $profile->recordEvent(ProfileEventType::randomValue(), [
            'test' => 'value',
        ]);

        $profile->refresh();

        $this->assertCount(1, $profile->events);
    }

    /** @test */
    public function it_can_get_the_has_consented_attribute()
    {
        $profile = factory(Profile::class)->create();

        $this->assertIsBool($profile->has_consented);
    }

    /** @test */
    public function it_can_find_an_equal_previous_event_without_data()
    {
        $profile = factory(Profile::class)->create();

        factory(ProfileEvent::class)->create([
            'profile_id' => $profile->local_id,
            'event_type' => ProfileEventType::VisitedPage,
        ]);

        $hasPreviousEvent = $profile->hasEqualPreviousEvent(ProfileEventType::VisitedPage);

        $this->assertTrue($hasPreviousEvent);
    }

    /** @test */
    public function it_can_find_an_equal_previous_event_with_data()
    {
        $profile = factory(Profile::class)->create();

        factory(ProfileEvent::class)->create([
            'profile_id' => $profile->local_id,
            'event_type' => ProfileEventType::VisitedPage,
            'data' => ['test' => 'value'],
        ]);

        $hasPreviousEvent = $profile->hasEqualPreviousEvent(ProfileEventType::VisitedPage, [
            'test' => 'value',
        ]);

        $this->assertTrue($hasPreviousEvent);
    }

    /** @test */
    public function it_returns_false_when_no_equal_previous_event_could_be_found()
    {
        $profile = factory(Profile::class)->create();

        $hasPreviousEvent = $profile->hasEqualPreviousEvent(ProfileEventType::VisitedPage, [
            'test' => 'value',
        ]);

        $this->assertFalse($hasPreviousEvent);
    }

    /** @test */
    public function it_can_identify_a_profile_via_email()
    {
        $profile = factory(Profile::class)->create();

        $request = Request::create('https://test-domain.com/?email=' . $profile->email);

        $this->assertEquals(Profile::identify($request, $profile->project)->first()->id, $profile->id);
    }

    /** @test */
    public function it_can_identify_a_profile_via_profile_id()
    {
        $profile = factory(Profile::class)->create();

        $request = Request::create('https://test-domain.com/?profile_id=' . $profile->profile_id);

        $this->assertEquals(Profile::identify($request, $profile->project)->first()->id, $profile->id);
    }

    /** @test */
    public function it_can_identify_a_profile_via_a_cookie()
    {
        $profile = factory(Profile::class)->create();

        $request = Request::create('https://test-domain.com/');
        $request->cookies->set('profile_id', $profile->profile_id);

        $this->assertEquals(Profile::identify($request, $profile->project)->first()->id, $profile->id);
    }
}
