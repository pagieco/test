<?php

namespace App\Models;

use App\Domains\Page\Models\Page;
use App\Domains\User\Models\User;
use App\Domains\Asset\Models\Asset;
use App\Domains\Profile\Models\Profile;
use App\Domains\Project\Models\Project;
use App\Domains\Form\Models\FormSubmission;
use App\Domains\Page\Observers\PageObserver;
use App\Domains\Profile\Models\ProfileEvent;
use App\Domains\User\Observers\UserObserver;
use App\Domains\Asset\Observers\AssetObserver;
use App\Domains\Profile\Observers\ProfileObserver;
use App\Domains\Project\Observers\ProjectObserver;
use App\Domains\Form\Observers\FormSubmissionObserver;
use App\Domains\Profile\Observers\ProfileEventObserver;

trait ModelObservers
{
    /**
     * The array of model observer mappings.
     *
     * @var array
     */
    protected $observers = [
        Asset::class => AssetObserver::class,
        FormSubmission::class => FormSubmissionObserver::class,
        Page::class => PageObserver::class,
        Profile::class => ProfileObserver::class,
        ProfileEvent::class => ProfileEventObserver::class,
        Project::class => ProjectObserver::class,
        User::class => UserObserver::class,
    ];
}
