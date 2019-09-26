<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetFolder extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asset_folders';

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
        'name', 'description',
    ];

    /**
     * Get the assets that belong to this folder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'local_id');
    }
}
