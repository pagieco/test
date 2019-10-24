<?php

namespace Tests\Feature\Domains\User;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCurrentUserControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_successfully_executes_the_get_current_user_route()
    {
        $this->login();

        $this->makeRequest()->assertSchema('GetCurrentUser', Response::HTTP_OK);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(): TestResponse
    {
        return $this->get(route('get-current-user'));
    }
}
