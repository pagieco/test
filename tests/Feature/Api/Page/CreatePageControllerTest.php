<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_permission_to_create_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_missing_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_already_used_in_the_project_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_missing_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_in_the_project_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_creating_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_successfully_creates_a_new_page()
    {
        $this->markTestIncomplete();
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->post(route('create-page', $data));
    }
}
