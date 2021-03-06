<?php

namespace App\Domains\Collection\Models;

use App\Models\Model;
use App\Models\Traits\HasExternalShardId;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;

class CollectionEntry extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_entries';

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
        'slug', 'name', 'entry_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'entry_data' => 'array',
    ];

    /**
     * The collection this entry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class, 'collection_id', 'local_id');
    }
}
