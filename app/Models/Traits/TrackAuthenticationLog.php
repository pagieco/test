<?php

namespace App\Models\Traits;

use App\Models\AuthenticationLog;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait TrackAuthenticationLog
{
    /**
     * Get the users' authentication logs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authentications(): HasMany
    {
        return $this->hasMany(AuthenticationLog::class)->latest('logged_in_at');
    }

    /**
     * Get the last login date.
     *
     * @return string|null
     */
    public function lastLoginAt(): ?string
    {
        return optional($this->authentications()->first())->logged_in_at;
    }

    /**
     * Get the last login ip address.
     *
     * @return string|null
     */
    public function lastLoginIp(): ?string
    {
        return optional($this->authentications()->first())->ip_address;
    }

    /**
     * Get the previous login date.
     *
     * @return string|null
     */
    public function previousLoginAt(): ?string
    {
        return optional($this->authentications()->skip(1)->first())->logged_in_at;
    }

    /**
     * Get the previous login ip.
     *
     * @return string|null
     */
    public function previousLoginIp(): ?string
    {
        return optional($this->authentications()->skip(1)->first())->ip_address;
    }
}
