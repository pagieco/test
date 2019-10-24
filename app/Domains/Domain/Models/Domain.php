<?php

namespace App\Domains\Domain\Models;

use App\Models\Model;
use App\Domains\Page\Models\Page;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Project\Models\Traits\BelongsToProject;

class Domain extends Model
{
    use BelongsToProject;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'domains';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_name',
        'gtm',
        'google_site_verification_id',
        'facebook_pixel_id',
        'timezone',
    ];

    /**
     * Get the pages that belong to this domain.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(): HasMany
    {
        return $this->hasMany(Page::class);
    }
}
