<?php

namespace App\Domains\Automation\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;

class AutomationNode extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'automation_steps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Get the automations that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function automation(): BelongsTo
    {
        return $this->belongsTo(Automation::class);
    }
}
