<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;

class RandomClassnameTest extends TestCase
{
    /** @test */
    public function it_gaaf()
    {
        $chars = strtolower(Str::random(rand(2, 10)).str_repeat('-', rand(1, 3)).Str::random(rand(2, 10)));

        dd($chars);
    }
}
