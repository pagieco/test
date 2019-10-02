<?php

namespace App\Models\Observers;

use App\Models\Page;
use App\Models\Domain;
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
        if (! $project->getAttribute('hash')) {
            $project->setAttribute('hash', Str::uuid());
        }

        if (! $project->getAttribute('api_token')) {
            $project->setAttribute('api_token', Project::generateApiToken());
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
        $domain = $this->createInitialDomain($project);

        $this->createInitialPage($domain);
    }

    /**
     * @param  \App\Models\Project $project
     * @return \App\Models\Domain|\Illuminate\Database\Eloquent\Model
     */
    protected function createInitialDomain(Project $project)
    {
        $subdomain = sprintf('%s.%s', Haiku::withToken(), config('app.domain'));

        return $project->domains()->create([
            'domain_name' => $subdomain,
        ]);
    }

    /**
     * @param  \App\Models\Domain $domain
     * @return \App\Models\Page
     */
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
