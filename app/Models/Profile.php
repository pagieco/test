<?php

namespace App\Models;

use Illuminate\Http\Request;
use App\Mail\ProfileConsentMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Enums\ProfileEventType;
use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\InvalidProfileTypeException;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
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
    protected $table = 'profiles';

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
        'email',
        'first_name',
        'last_name',
        'address_1',
        'address_2',
        'city',
        'state',
        'zip',
        'country',
        'phone',
        'timezone',
        'tags',
        'custom_fields',
        'consented_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'consented_at',
        'first_seen_at',
        'last_seen_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
        'custom_fields' => 'array',
    ];

    /**
     * Get the events that belong to this profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(ProfileEvent::class, 'profile_id', 'local_id')->orderBy('occurred_at');
    }

    /**
     * Get the has-consented attribute.
     *
     * @return bool
     */
    public function getHasConsentedAttribute(): bool
    {
        return $this->consented_at !== null;
    }

    /**
     * Give consent.
     *
     * @return void
     */
    public function giveConsent(): void
    {
        $this->consented_at = now();

        $this->save();
    }

    /**
     * Send the profile consent confirmation email.
     *
     * @return void
     */
    public function sendConsentConfirmationEmail(): void
    {
        Mail::to($this->email)->queue(new ProfileConsentMail($this));
    }

    /**
     * @param  string $type
     * @param  array $data
     * @return \App\Models\ProfileEvent
     * @throws \App\Exceptions\InvalidProfileTypeException
     * @throws \ReflectionException
     */
    public function recordEvent(string $type, array $data): ProfileEvent
    {
        if (! in_array($type, ProfileEventType::getValues())) {
            throw new InvalidProfileTypeException('Invalid profile type: ' . $type);
        }

        $event = new ProfileEvent([
            'event_type' => $type,
            'data' => array_filter($data),
        ]);

        $event->profile()->associate($this);
        $event->project()->associate($this->project);

        return tap($event)->save();
    }

    /**
     * Determine if the previous event equals the given event
     *
     * @param  string $eventType
     * @param  array $eventData
     * @return bool
     */
    public function hasEqualPreviousEvent(string $eventType, array $eventData = []): bool
    {
        $event = $this->events->last();

        $hasEvent = $event !== null && $event->event_type === $eventType;

        if (! $hasEvent) {
            return false;
        }

        if ($event->data === null) {
            return $hasEvent;
        }

        return empty(array_diff($eventData, $event->data));
    }

    /**
     * Scope the query by email.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  string $email
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeByEmail($builder, string $email)
    {
        return $builder->where('email', $email);
    }

    /**
     * Scope the query by profile id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  string $profileId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeByProfileId(Builder $builder, string $profileId)
    {
        return $builder->where('profile_id', $profileId);
    }

    public static function identify(Request $request, Project $project): ?Profile
    {
        if ($request->has('email')) {
            return $project->profiles()->byEmail($request->get('email'))->first();
        }

        if ($request->has('profile_id')) {
            return $project->profiles()->byProfileId($request->get('profile_id'))->first();
        }

        if ($request->hasCookie('profile_id')) {
            return $project->profiles()->byProfileId($request->cookie('profile_id'))->first();
        }

        return null;
    }
}
