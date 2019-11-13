<?php

namespace App\Domains\Project\Observers;

use App\Support\Haiku;
use Illuminate\Support\Str;
use App\Domains\Page\Models\Page;
use App\Domains\Domain\Models\Domain;
use App\Domains\Project\Models\Project;

class ProjectObserver
{
    public function creating(Project $project): void
    {
        if (! $project->getAttribute('hash')) {
            $project->setAttribute('hash', Str::uuid());
        }

        if (! $project->getAttribute('api_token')) {
            $project->setAttribute('api_token', Project::generateApiToken());
        }
    }

    public function created(Project $project): void
    {
        $domain = $this->createInitialDomain($project);

        $this->createInitialPage($domain);
    }

    protected function createInitialDomain(Project $project)
    {
        $subdomain = sprintf('%s.%s', Haiku::withToken(), config('app.domain'));

        return $project->domains()->create([
            'domain_name' => $subdomain,
            'timezone' => 'UTC',
        ]);
    }

    protected function createInitialPage(Domain $domain): Page
    {
        $homepage = new Page([
            'name' => 'Homepage',
            'slug' => '/',
        ]);

        $homepage->domain()->associate($domain);
        $homepage->project()->associate($domain->project);

        return tap($homepage)->save();
    }
}
