<?php

namespace Tests\Feature\Domains\Profile;

use Tests\TestCase;
use App\Http\Response;
use Illuminate\Support\Facades\URL;
use App\Domains\Profile\Models\Profile;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ConfirmProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_profile_could_not_be_found()
    {
        $this->makeRequest()->assertSchema('ConfirmProfile', Response::HTTP_NOT_FOUND);
    }

    /** @test */
    public function it_throws_a_406_not_acceptable_excetion_when_the_route_has_no_valid_signature()
    {
        $profile = factory(Profile::class)->create();

        $this->makeRequest($profile->external_id)->assertSchema('ConfirmProfile', Response::HTTP_NOT_ACCEPTABLE);
    }

    /** @test */
    public function it_successfully_executes_the_confirm_profile_route()
    {
        $profile = factory(Profile::class)->create();

        $this->assertFalse($profile->has_consented);

        $route = URL::temporarySignedRoute('confirm-profile-consent', now()->addDays(30), $profile->external_id);

        $this->get($route)->assertSchema('ConfirmProfile', Response::HTTP_OK);

        $profile->refresh();

        $this->assertTrue($profile->has_consented);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  null $id
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest($id = null, array $data = []): TestResponse
    {
        return $this->get(route('confirm-profile-consent', $id ?? faker()->numberBetween(1)), $data);
    }
}
