<?php

namespace App\Models\Observers;

use App\Support\Haiku;
use App\Models\Project;
use Illuminate\Support\Str;

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
        $project->setAttribute('hash', Str::uuid());
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
