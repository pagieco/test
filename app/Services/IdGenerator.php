<?php

namespace App\Services;

class IdGenerator
{
    /**
     * Encode the 64 bits ID (24 bits shard ID and 40 bits local ID).
     *
     * @param  int $shard
     * @param  int $local
     * @return int
     */
    public static function encode(int $shard, int $local): int
    {
        return ($shard << 40) | $local;
    }

    /**
     * Decode the 64 bits id.
     *
     * @param  int $id
     * @return array
     */
    public static function decode(int $id): array
    {
        $shard = ($id >> 40) & 0xFFFFFF;
        $local = ($id) & 0xFFFFFFFFFF;

        return compact('shard', 'local');
    }
}
