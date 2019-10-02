<?php

namespace App\Providers;

use App\Models;
use App\Policies;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Models\Asset::class => Policies\AssetPolicy::class,
        Models\AssetFolder::class => Policies\AssetFolderPolicy::class,
        Models\Automation::class => Policies\AutomationPolicy::class,
        Models\Collection::class => Policies\CollectionPolicy::class,
        Models\Domain::class => Policies\DomainPolicy::class,
        Models\Email::class => Policies\EmailPolicy::class,
        Models\Form::class => Policies\FormPolicy::class,
        Models\Page::class => Policies\PagePolicy::class,
        Models\Profile::class => Policies\ProfilePolicy::class,
        Models\Project::class => Policies\ProjectPolicy::class,
        Models\Workflow::class => Policies\WorkflowPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
