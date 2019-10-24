<?php

namespace App\Domains\Form\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;

class FormField extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'slug',
        'display_name',
        'validations',
        'is_profile_identifier',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validations' => 'json',
        'is_profile_identifier' => 'bool',
    ];

    /**
     * Get the form this submission is attached to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
