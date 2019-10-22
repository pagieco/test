<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Events\ProjectShared;
use App\Events\ProjectUnshared;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'hash', // Used for e.g. folders paths etc
        'api_token',
        'used_storage',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'used_storage' => 'int',
    ];

    public function incrementUsedStorageWith(int $bytes)
    {
        $this->used_storage += $bytes;

        $this->save();
    }

    public function decrementUsedStorageBy(int $bytes)
    {
        $this->used_storage -= $bytes;

        $this->save();
    }

    /**
     * Get all the assets that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Get all the asset-folders that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assetFolders(): HasMany
    {
        return $this->hasMany(AssetFolder::class);
    }

    /**
     * Get all the automations that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function automations(): HasMany
    {
        return $this->hasMany(Automation::class);
    }

    /**
     * All the collaborators that belong to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')->using(Collaborator::class);
    }

    /**
     * Get all the collections that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

    /**
     * Get all the domains that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    /**
     * Get all the emails that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails(): HasMany
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Get the user that owns this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all the forms that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forms(): HasMany
    {
        return $this->hasMany(Form::class);
    }

    /**
     * Get all the pages that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }

    /**
     * Get all the profiles that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class);
    }

    /**
     * Get all the workflows that belong to this project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workflows(): HasMany
    {
        return $this->hasMany(Workflow::class);
    }

    /**
     * Share the project with the given user.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function shareWith(User $user): void
    {
        $this->collaborators()->detach($user);
        $this->collaborators()->attach($user);

        ProjectShared::dispatch($this, $user);
    }

    /**
     * Stop sharing the project with the given user.
     *
     * @param  \App\Models\User $user
     * @return void
     */
    public function stopSharingWith(User $user): void
    {
        $this->collaborators()->detach($user);

        ProjectUnshared::dispatch($this, $user);
    }

    /**
     * Generate an api token for this project.
     *
     * @return string
     */
    public static function generateApiToken(): string
    {
        return strtolower(Str::random(60));
    }
}
