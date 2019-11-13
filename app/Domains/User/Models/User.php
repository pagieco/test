<?php

namespace App\Domains\User\Models;

use App\Services\Gravatar;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Domains\Auth\Models\Traits\HasPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Domains\Auth\Models\Traits\TrackAuthenticationLog;
use App\Domains\Project\Models\Traits\InteractsWithProjects;

/**
 * @property int id
 * @property int current_project_id
 * @property string name
 * @property string email
 * @property string password
 * @property string remember_token
 * @property string picture
 * @property boolean has_access_to_backoffice
 * @property \Illuminate\Support\Carbon created_at
 * @property \Illuminate\Support\Carbon updated_at
 * @property \Illuminate\Support\Collection projects
 * @property \Illuminate\Support\Collection teamProjects
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasPermissions;
    use InteractsWithProjects;
    use TrackAuthenticationLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'picture', 'has_access_to_backoffice',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'has_access_to_backoffice' => 'bool',
    ];

    /**
     * Determine if the user has access to the backoffice.
     *
     * @return bool
     */
    public function getHasAccessToBackofficeAttribute(): bool
    {
        return $this->has_access_to_backoffice;
    }

    /**
     * Get the email hash attribute.
     * This is primarily used for the gravatar hash.
     *
     * @return string
     */
    public function getEmailHashAttribute(): string
    {
        return md5(strtolower($this->email));
    }

    /**
     * Upload the user's profile picture.
     *
     * @param  \Illuminate\Http\UploadedFile $file
     * @return mixed
     */
    public function uploadProfilePicture(UploadedFile $file)
    {
        $filename = sprintf('%s.%s', $this->id, $file->getClientOriginalExtension());

        return $file->storeAs(null, $filename);
    }

    /**
     * Try to fetch the user's profile picture from the Gravatar service.
     *
     * @return void
     */
    public function fetchGravatar()
    {
        if ($gravatar = app(Gravatar::class)->fetch($this->email_hash)) {
            $filename = sprintf('profile-pictures/%s.jpeg', $this->email_hash);

            Storage::put($filename, $gravatar);

            $this->update(['picture' => $filename]);
        }
    }
}
