<?php

namespace App\Domains\Auth\Models;

use App\Models\Model;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthenticationLog extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'authentication_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
        'logged_in_at',
        'logged_out_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    /**
     * Get the user that belongs to this authentication log entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
