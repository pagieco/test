<?php

namespace App\Domains\Page\Models;

use App\Dom;
use App\Stylesheet;
use App\Models\Model;
use Illuminate\Support\Facades\DB;
use App\Domains\Domain\Models\Domain;
use App\Models\Traits\HasExternalShardId;
use App\Domains\Page\Renderers\PageRenderer;
use Illuminate\Contracts\Support\Responsable;
use App\Domains\Page\Compilers\Dom\DomCompiler;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;
use App\Domains\Page\Compilers\StyleSheet\StylesheetCompiler;
use App\Domains\Workflow\Models\Traits\InteractsWithWorkflows;

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

    /**
     * Publish this page.
     *
     * @param  array $dom
     * @param  array $css
     * @return void
     */
    public function publish(array $dom, array $css)
    {
        DB::transaction(function () use ($dom, $css) {
            $publicationDate = now();

            $this->update([
                'dom' => (new DomCompiler)->compile($dom),
                'published_at' => $publicationDate,
            ]);

            $this->project->update([
                'css_rules' => $css,
            ]);

            $this->project->recompileStylesheet($publicationDate);
        });
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function toResponse($request)
    {
        return PageRenderer::fromResource($this)->render();
    }
}
