<?php

namespace App\Domains\Form\Models;

use App\Models\Model;
use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Project\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Form extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the fields that belong to this form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    /**
     * Get the submissions that belong to this form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(FormSubmission::class)->orderBy('order');
    }

    /**
     * The users that are subscribed to the notifications of this form.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'form_user');
    }

    /**
     * Get the profile identification field.
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function getProfileIdentifierField()
    {
        return $this->fields()
            ->where('is_profile_identifier', true)
            ->where('type', 'email')
            ->first();
    }

    /**
     * Subscribe to the form notifications.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return void
     */
    public function subscribeToNotifications(User $user): void
    {
        $this->subscribers()->attach($user);
    }

    /**
     * Unsubscribe from the form notifications.
     *
     * @param  \App\Domains\User\Models\User $user
     * @return void
     */
    public function unsubscribeFromNotifications(User $user): void
    {
        $this->subscribers()->detach($user);
    }
}
