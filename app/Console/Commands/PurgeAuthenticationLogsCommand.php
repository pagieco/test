<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AuthenticationLog;

class PurgeAuthenticationLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:purge-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge the authentication logs';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Purging authentication logs...');

        $from = now()->subDays(60)->format('Y-m-d H:i:s');

        AuthenticationLog::where('logged_in_at', '<', $from)->delete();

        $this->info('Authentication logs purged successfully.');
    }
}
