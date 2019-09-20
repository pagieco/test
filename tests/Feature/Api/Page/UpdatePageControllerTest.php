<?php

namespace Tests\Feature\Api\Page;

use Tests\TestCase;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePageControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_could_not_be_found()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_403_forbidden_exception_when_the_user_has_no_access_to_the_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_404_not_found_exception_when_the_page_exists_but_is_not_part_of_the_project()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_exists_but_is_empty_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_short_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_is_too_long_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_name_already_exists_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_exists_but_is_empty_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_is_too_long_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_slug_already_exists_when_updating_a_page()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_successfully_executes_the_update_page_route()
    {
        $this->markTestIncomplete();
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
        return $this->patch(route('update-page', $id ?? faker()->randomNumber()), $data);
    }
}
