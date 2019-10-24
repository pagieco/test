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
        'name', 'email', 'password', 'picture',
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
    ];

    public function getEmailHashAttribute(): string
    {
        return md5(strtolower($this->email));
    }

    public function uploadProfilePicture(UploadedFile $file)
    {
        $filename = sprintf('%s.%s', $this->id, $file->getClientOriginalExtension());

        $path = $file->storeAs(null, $filename);

        return $path;
    }

    public function fetchGravatar()
    {
        if ($gravatar = app(Gravatar::class)->fetch($this->email_hash)) {
            $filename = sprintf('profile-pictures/%s.jpeg', $this->email_hash);

            Storage::put($filename, $gravatar);

            $this->update(['picture' => $filename]);
        }
    }
}
