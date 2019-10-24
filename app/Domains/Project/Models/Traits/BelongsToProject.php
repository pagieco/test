<?php

namespace App\Domains\Project\Models\Traits;

use App\Domains\Project\Models\Project;
use App\Domains\Project\Scopes\ProjectScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToProject
{
    /**
     * Get the project that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Boot the `belongsToProject` trait.
     *
     * @return void
     */
    protected static function bootBelongsToProject(): void
    {
        static::addGlobalScope(new ProjectScope);
    }
}
