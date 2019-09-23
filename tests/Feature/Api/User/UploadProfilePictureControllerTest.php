<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use App\Http\Response;
use Illuminate\Http\UploadedFile;
use Tests\Feature\AuthenticatedRoute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadProfilePictureControllerTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatedRoute;

    /** @test */
    public function it_throws_a_422_exception_when_the_picture_is_not_posted_when_uploading_the_profile_picture()
    {
        Storage::fake();

        $this->login();

        $this->makeRequest()->assertSchema('UploadProfilePicture', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_throws_a_422_exception_when_the_picture_is_not_an_image_when_uploading_the_profile_picture()
    {
        Storage::fake();

        $this->login();

        $this->makeRequest([
            'picture' => UploadedFile::fake()->create('picture.pdf'),
        ])->assertSchema('UploadProfilePicture', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function it_successfully_executes_the_upload_profile_picture_route()
    {
        Storage::fake();

        $this->login();

        $this->makeRequest([
            'picture' => UploadedFile::fake()->create('picture.jpeg'),
        ])->assertSchema('UploadProfilePicture', Response::HTTP_CREATED);
    }

    /**
     * Prepare the authenticated route request.
     *
     * @param  array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    protected function makeRequest(array $data = []): TestResponse
    {
        return $this->put(route('upload-profile-picture'), $data);
    }
}
