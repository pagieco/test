<?php

namespace App\Models;

use App\Models\Observers\PageObserver;
use App\Models\Observers\UserObserver;
use App\Models\Observers\AssetObserver;
use App\Models\Observers\ProfileObserver;
use App\Models\Observers\ProjectObserver;
use App\Models\Observers\FormSubmissionObserver;

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
        Project::class => ProjectObserver::class,
        User::class => UserObserver::class,
    ];
}
