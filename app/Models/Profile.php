<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

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
        return $this->hasMany(ProfileEvent::class, 'profile_id', 'local_id');
    }
}
