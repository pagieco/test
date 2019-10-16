<?php

namespace App\Models;

use App\Dom;
use App\Stylesheet;
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
        'name', 'slug', 'published_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at',
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

    public function publish($dom, $css)
    {
        $document = Dom::createDocument($dom);
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function toResponse($request)
    {
        return (new PageRenderer($request))->fromResourceInstance($this)->render();
    }
}
