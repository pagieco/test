<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Support\Haiku;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HaikuTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_random_pretty_name()
    {
        $haiku = Haiku::name();

        $parts = explode('-', $haiku);

        $this->assertCount(2, $parts);
    }

    /** @test */
    public function it_can_create_a_random_pretty_name_with_an_additional_random_token()
    {
        $haiku = Haiku::withToken();

        $parts = explode('-', $haiku);

        $this->assertCount(3, $parts);
    }
}
