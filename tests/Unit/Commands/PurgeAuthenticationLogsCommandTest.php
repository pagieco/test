<?php

namespace Tests\Unit\Commands;

use Tests\TestCase;
use App\Models\AuthenticationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Console\Commands\PurgeAuthenticationLogsCommand;

class PurgeAuthenticationLogsCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_wont_purge_records_younger_than_60_days()
    {
        factory(AuthenticationLog::class)->create([
            'logged_in_at' => now()->subDays(60)
        ]);

        $this->assertCount(1, AuthenticationLog::all());

        $this->artisan(PurgeAuthenticationLogsCommand::class);

        $this->assertCount(1, AuthenticationLog::all());
    }

    /** @test */
    public function it_will_purge_records_older_than_60_days()
    {
        factory(AuthenticationLog::class)->create([
            'logged_in_at' => now()->subDays(65)
        ]);

        $this->assertCount(1, AuthenticationLog::all());

        $this->artisan(PurgeAuthenticationLogsCommand::class);

        $this->assertCount(0, AuthenticationLog::all());
    }
}
