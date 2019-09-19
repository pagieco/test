<?php

namespace App\Models\Traits;

use App\Models\Project;
use App\Models\Scopes\ProjectScope;
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
