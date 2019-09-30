<?php

namespace App\Models\Observers;

use App\Support\Haiku;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ProjectObserver
{
    /**
     * Listen to the project model "creating" event.
     *
     * @param  \App\Models\Project $project
     * @return void
     */
    public function creating(Project $project): void
    {
        if (! $project->getAttribute('hash')) {
            $project->setAttribute('hash', Str::uuid());
        }

        if (! $project->getAttribute('api_token')) {
            $project->setAttribute('api_token', $project->generateApiToken());
        }
    }

    /**
     * Listen to the project model "created" event.
     *
     * @param  \App\Models\Project $project
     * @return void
     */
    public function created(Project $project): void
    {
        $subdomain = sprintf('%s.%s', Haiku::withToken(), config('app.domain'));

        $project->domains()->create([
            'domain_name' => $subdomain,
        ]);
    }
}
