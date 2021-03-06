<?php

namespace App\Domains\Asset\Models;

use App\Models\Model;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use App\Domains\Project\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Models\Traits\HasExternalShardId;
use Intervention\Image\Image as InterventionImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Project\Models\Traits\BelongsToProject;

/**
 * @property int local_id
 * @property int external_id
 * @property int project_id
 * @property int asset_folder_id
 * @property string hash
 * @property string filename
 * @property string original_filename
 * @property string caption
 * @property string description
 * @property string extension
 * @property string mime_type
 * @property int file_size
 * @property array extra_attributes
 * @property string path
 * @property string thumb_path
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 * @property \App\Domains\Project\Models\Project project
 */
class Asset extends Model
{
    use BelongsToProject;
    use HasExternalShardId;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assets';

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
        'hash',
        'filename',
        'original_filename',
        'caption',
        'description',
        'extension',
        'mime_type',
        'file_size',
        'extra_attributes',
        'path',
        'thumb_path',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'extra_attributes' => 'array',
        'external_id' => 'int',
    ];

    /**
     * Get the hash attribute.
     *
     * @return string
     */
    public function getHashPathAttribute(): string
    {
        $path = $this->getAttribute('path');
        $hash = $this->getAttribute('hash');

        return sprintf('%s?id=%s', $path, $hash);
    }

    /**
     * Get the asset-folder that belongs to this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(AssetFolder::class, 'asset_folder_id');
    }

    /**
     * Create a tumbnail for this asset.
     *
     * @return $this|\App\Domains\Asset\Models\Asset
     */
    public function createThumbnail(): Asset
    {
        if (! $this->isImage()) {
            return $this;
        }

        $filename = sprintf('%s/thumbnail_%s', $this->project->hash, $this->original_filename);

        Storage::disk()->put($filename, (string) $this->resizeImage(150)->encode());

        $this->update(['thumb_path' => $filename]);

        return $this->refresh();
    }

    /**
     * Determine that this asset is an image.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return Str::contains($this->mime_type, 'image');
    }

    /**
     * Get the path to this asset.
     *
     * @param  string|null $filename
     * @return string
     */
    public function getPath(string $filename = null): string
    {
        if ($filename === null) {
            $filename = sprintf('%s/%s', $this->project->hash, $this->filename);
        }

        return Storage::disk()->path($filename);
    }

    /**
     * Delete this asset.
     *
     * @throws \Exception
     */
    public function unlink(): void
    {
        Storage::disk()->delete($this->path);

        $this->delete();
    }

    /**
     * Move the asset to a new folder.
     *
     * @param  \App\Domains\Asset\Models\AssetFolder $folder
     * @return void
     */
    public function moveTo(AssetFolder $folder): void
    {
        if ($this->asset_folder_id !== $folder->id) {
            $this->folder()->associate($folder);
            $this->save();
        }
    }

    /**
     * Upload the given file and create a new asset instance.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @param  \App\Domains\Project\Models\Project $project
     * @param  \App\Domains\Asset\Models\AssetFolder|null $folder
     * @return \App\Domains\Asset\Models\Asset
     */
    public static function upload(UploadedFile $file, Project $project, AssetFolder $folder = null): Asset
    {
        $path = $file->storeAs($project->hash, $file->getClientOriginalName());

        $asset = new static([
            'hash' => static::getContentHash($file),
            'filename' => $file->getClientOriginalName(),
            'original_filename' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'extra_attributes' => static::getExtraAttributes($file),
            'path' => $path,
        ]);

        $asset->project()->associate($project);

        if ($folder) {
            $asset->folder()->associate($folder);
        }

        $asset->save();

        return tap($asset)->fill(['path' => $path]);
    }

    /**
     * Create a hash of the file contents.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return string
     */
    public static function getContentHash(UploadedFile $file): string
    {
        $contents = $file->openFile()->fread($file->getSize());

        return substr(md5($contents), 0, 20);
    }

    /**
     * Get the extra attributes of a file (e.g.: width, height, etc..)
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public static function getExtraAttributes(UploadedFile $file): array
    {
        if (strpos($file->getMimeType(), 'image') === 0) {
            [$width, $height] = getimagesize($file);

            return [
                'width' => $width,
                'height' => $height,
            ];
        }

        return [];
    }

    /**
     * Resize the given image to a certain size.
     *
     * @param  int $size
     * @return \Intervention\Image\Image
     */
    protected function resizeImage(int $size): InterventionImage
    {
        return Image::make($this->getPath($this->path))
            ->resize(null, $size, static function (Constraint $constraint): void {
                $constraint->aspectRatio();
            });
    }
}
