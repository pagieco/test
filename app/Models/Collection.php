<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collection extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collections';

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
        'name', 'slug',
    ];

    /**
     * Get the entries that belong to this collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(CollectionEntry::class);
    }

    /**
     * Get the fields that belong to this collection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields(): HasMany
    {
        return $this->hasMany(CollectionField::class, 'local_id')->orderBy('sort_order');
    }
}
