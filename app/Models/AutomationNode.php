<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AutomationNode extends Model
{
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
