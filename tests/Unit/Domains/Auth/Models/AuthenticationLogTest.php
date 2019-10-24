<?php

namespace Tests\Unit\Domains\Auth\Models;

use Tests\TestCase;
use App\Domains\Auth\Models\AuthenticationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthenticationLogTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertInstanceOf(BelongsTo::class, app(AuthenticationLog::class)->user());
    }
}
