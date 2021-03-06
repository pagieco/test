<?php

namespace App\Domains\Automation\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Project\Models\Traits\BelongsToProject;

class Automation extends Model
{
    use BelongsToProject;

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
     * Get the automations nodes that belong to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(AutomationNode::class);
    }
}
