<?php

namespace Tests\Feature\Api\AssetFolder;

use Tests\TestCase;
use App\Http\Response;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateAssetFoldersControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test folder',
            'description' => 'Test description'
        ])->assertSchema('CreateAssetFolder', Response::HTTP_FORBIDDEN);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'description' => 'Test description'
        ])->assertSchema('CreateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'a',
            'description' => 'Test description'
        ])->assertSchema('CreateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'name' => str_repeat('a', 251),
            'description' => 'Test description'
        ])->assertSchema('CreateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_short_when_creating_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test folder',
            'description' => 'a',
        ])->assertSchema('CreateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_description_is_too_long_when_creating_a_new_folder()
    {
        $this->login();

        $this->makeRequest([
            'name' => 'Test folder',
            'description' => str_repeat('a', 251),
        ])->assertSchema('CreateAssetFolder', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_create_asset_folder_route()
    {
        $this->login()->forceAccess($this->role, 'asset-folder:create');

        $this->makeRequest([
            'name' => 'Test folder',
            'description' => 'Test description'
        ])->assertSchema('CreateAssetFolder', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-asset-folder', $data));
    }
}
