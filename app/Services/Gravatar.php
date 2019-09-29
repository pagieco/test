<?php

namespace App\Services;

use App\Http\Curl;
use App\Exceptions\CurlRequestException;

class Gravatar
{
    /**
     * The cUrl instance.
     *
     * @var \App\Http\Curl
     */
    protected $curl;

    /**
     * Create a new gravatar instance.
     *
     * @param  \App\Http\Curl $curl
     * @return void
     */
    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    /**\
     * @param  string $hash
     * @return string|null
     * @throws \Throwable
     */
    public function fetch(string $hash): ?string
    {
        try {
            return $this->curl::get($this->constructUrlFrom($hash));
        } catch (CurlRequestException $e) {
            return null;
        }
    }

    /**
     * @param  string $hash
     * @return string
     */
    public function constructUrlFrom(string $hash): string
    {
        $base = 'https://www.gravatar.com/avatar/' . $hash;

        return $base . '?' . http_build_query([
            's' => 100,
            'd' => 404,
            'r' => 'r',
        ]);
    }
}
