<?php

namespace App\Domains\Asset\Models;

use App\Models\Model;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Project\Models\Traits\BelongsToProject;

/**
 * @property int local_id
 * @property int external_id
 * @property int project_id
 * @property string name
 * @property string description
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 * @property \Illuminate\Support\Collection assets
 */
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
