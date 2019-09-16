<?php

namespace App\Models\Observers;

use App\Support\Haiku;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectObserver
{
    public function creating(Project $project)
    {
        $project->setAttribute('hash', Str::uuid());
    }

    public function created(Project $project)
    {
        $subdomain = sprintf('%s.%s', Haiku::withToken(), config('app.domain'));

        $project->domains()->create([
            'domain_name' => $subdomain,
        ]);
    }
}
