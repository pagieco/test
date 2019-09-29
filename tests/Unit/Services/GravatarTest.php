<?php

namespace Tests\Unit\Services;

use finfo;
use Tests\TestCase;
use App\Models\User;
use App\Services\Gravatar;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GravatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_correctly_constructs_a_url_from_a_hash()
    {
        $user = factory(User::class)->create([
            'email' => 'matt@mullenweg.com',
        ]);

        $this->assertEquals(
            'https://www.gravatar.com/avatar/d5d30d232682e6176045145b20befc5c?s=100&d=404&r=r',
            app(Gravatar::class)->constructUrlFrom($user->email_hash)
        );
    }

    /** @test */
    public function it_correctly_fetches_the_gravatar()
    {
        $user = factory(User::class)->create([
            'email' => 'matt@mullenweg.com',
        ]);

        $finfo = new finfo(FILEINFO_MIME_TYPE);

        $this->assertEquals('image/jpeg', $finfo->buffer(app(Gravatar::class)->fetch($user->email_hash)));
    }

    /** @test */
    public function it_returns_null_when_the_gravatar_could_not_be_fetched()
    {
        $user = factory(User::class)->create([
            'email' => faker()->email,
        ]);

        $this->assertNull(app(Gravatar::class)->fetch($user->email_hash));
    }
}
