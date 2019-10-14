<?php

namespace App\Models;

use App\Models\Enums\ProfileEventType;
use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileEvent extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

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
    protected $table = 'profile_events';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'local_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_type', 'data', 'occurred_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'occurred_at',
    ];

    /**
     * Get the profile that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'local_id');
    }

    /**
     * @param  \App\Models\Profile $profile
     * @return \App\Models\ProfileEvent
     * @throws \App\Exceptions\InvalidProfileTypeException
     * @throws \ReflectionException
     */
    public static function recordVisitedPage(Profile $profile): ?ProfileEvent
    {
        $hasPreviousEvent = $profile->hasEqualPreviousEvent(ProfileEventType::VisitedPage, [
            'path' => request()->path(),
        ]);

        if (! $hasPreviousEvent) {
            return $profile->recordEvent(ProfileEventType::VisitedPage, [
                'url' => request()->url(),
                'path' => request()->path(),
                'referer' => request()->server('HTTP_REFERER'),
            ]);
        }

        return null;
    }
}
