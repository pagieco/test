<?php

namespace App\Models;

use Illuminate\View\View;
use App\Renderers\PageRenderer;
use App\Models\Traits\BelongsToProject;
use App\Models\Traits\HasExternalShardId;
use App\Models\Traits\InteractsWithWorkflows;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model implements Responsable
{
    use BelongsToProject;
    use HasExternalShardId;
    use InteractsWithWorkflows;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

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
     * Get the domain this page belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function domain(): BelongsTo
    {
        return $this->belongsTo(Domain::class);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function toResponse($request): View
    {
        return (new PageRenderer($request))->fromResourceInstance($this)->render();
    }
}
