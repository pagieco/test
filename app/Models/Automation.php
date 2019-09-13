<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Automation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'automations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Get the project that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the automations nodes that belong to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(AutomationNode::class);
    }
}
