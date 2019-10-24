<?php

namespace App\Domains\Form\Models;

use App\Models\Model;
use App\Domains\Profile\Models\Profile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;

class FormSubmission extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_submissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'submission_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'submission_data' => 'array',
    ];

    /**
     * Get the form that belongs to this submission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Get the profile that belongs to this submission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'local_id');
    }
}
