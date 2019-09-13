<?php

namespace App\Models\Observers;

use App\Support\Haiku;
use App\Models\Project;

class ProjectObserver
{
    public function created(Project $project)
    {
        $subdomain = sprintf('%s.%s', Haiku::withToken(), config('app.domain'));

        $project->domains()->create([
            'domain_name' => $subdomain,
        ]);
    }
}
