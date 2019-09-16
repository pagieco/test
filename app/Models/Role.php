<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',
    ];

    /**
     * Get the project that this model belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the permissions that belong to this role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    /**
     * Assign permissions to this role.
     *
     * @param  string|array ...$permissions
     * @return void
     */
    public function assignPermission(...$permissions): void
    {
        $permissions = Arr::flatten($permissions);
        $permissions = $this->getPermissions($permissions);

        if ($permissions) {
            $this->permissions()->syncWithoutDetaching($permissions);
        }
    }

    /**
     * Revoke the given permissions.
     *
     * @param  string|array ...$permissions
     * @return void
     */
    public function revokePermission(...$permissions): void
    {
        $permissions = Arr::flatten($permissions);
        $permissions = $this->getPermissions($permissions);

        $this->permissions()->detach($permissions);
    }

    /**
     * Get the specified permissions.
     *
     * @param  array $permissions
     * @return mixed
     */
    protected function getPermissions(array $permissions)
    {
        return Permission::select('id')
            ->whereIn('slug', $permissions)
            ->get();
    }
}