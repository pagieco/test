<?php

namespace Tests\Feature\Api\Asset;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAssetsControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_an_empty_response_when_no_assets_where_found()
    {
        $this->login();

        $response = $this->get(route('get-assets'));

        $response->assertSchema('GetAssets', Response::HTTP_NO_CONTENT);
    }
}
