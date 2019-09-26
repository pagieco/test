<?php

namespace App\Models;

use Illuminate\View\View;
use App\Renderers\PageRenderer;
use App\Models\Traits\BelongsToProject;
use App\Models\Traits\InteractsWithWorkflows;
use Illuminate\Contracts\Support\Responsable;

class Page extends Model implements Responsable
{
    use BelongsToProject;
    use InteractsWithWorkflows;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

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
