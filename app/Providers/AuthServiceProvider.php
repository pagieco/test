<?php

namespace App\Providers;

use App\Domains\Form\Models\Form;
use App\Domains\Page\Models\Page;
use App\Domains\Asset\Models\Asset;
use App\Domains\Email\Models\Email;
use App\Domains\Domain\Models\Domain;
use App\Domains\Profile\Models\Profile;
use App\Domains\Project\Models\Project;
use App\Domains\Asset\Models\AssetFolder;
use App\Domains\Form\Policies\FormPolicy;
use App\Domains\Page\Policies\PagePolicy;
use App\Domains\Workflow\Models\Workflow;
use App\Domains\Asset\Policies\AssetPolicy;
use App\Domains\Email\Policies\EmailPolicy;
use App\Domains\Automation\Models\Automation;
use App\Domains\Collection\Models\Collection;
use App\Domains\Domain\Policies\DomainPolicy;
use App\Domains\Profile\Policies\ProfilePolicy;
use App\Domains\Project\Policies\ProjectPolicy;
use App\Domains\Asset\Policies\AssetFolderPolicy;
use App\Domains\Workflow\Policies\WorkflowPolicy;
use App\Domains\Automation\Policies\AutomationPolicy;
use App\Domains\Collection\Policies\CollectionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Asset::class => AssetPolicy::class,
        AssetFolder::class => AssetFolderPolicy::class,
        Automation::class => AutomationPolicy::class,
        Collection::class => CollectionPolicy::class,
        Domain::class => DomainPolicy::class,
        Email::class => EmailPolicy::class,
        Form::class => FormPolicy::class,
        Page::class => PagePolicy::class,
        Profile::class => ProfilePolicy::class,
        Project::class => ProjectPolicy::class,
        Workflow::class => WorkflowPolicy::class,
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
