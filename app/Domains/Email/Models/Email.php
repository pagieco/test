<?php

namespace App\Domains\Email\Models;

use App\Models\Model;
use App\Domains\Project\Models\Traits\BelongsToProject;

class Email extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'emails';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
