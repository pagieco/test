<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Traits\BelongsToProject;
use Jenssegers\Mongodb\Relations\HasMany;
use Jenssegers\Mongodb\Relations\EmbedsMany;

class Collection extends Model
{
    use BelongsToProject;

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * The collection associated with the model.
     *
     * @var string
     */
    protected $collection = 'collections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Get the entries that belong to this collection.
     *
     * @return \Jenssegers\Mongodb\Relations\HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(CollectionEntry::class);
    }

    /**
     * Get the fields that belong to this collection.
     *
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function fields(): EmbedsMany
    {
        return $this->embedsMany(CollectionField::class);
    }
}
