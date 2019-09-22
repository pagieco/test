<?php

namespace App\Support;

abstract class ClusterId
{
    /**
     * Encode a 62 bits cluster id.
     *
     * @param  int $shard
     * @param  int $table
     * @param  int $local
     * @return int
     */
    public static function encode(int $shard, int $table, int $local): int
    {
        return ($shard << 46) | ($table << 36) | ($local << 0);
    }

    /**
     * Decode a 62 bits cluster id.
     *  - shard = 16 bits
     *  - table = 10 bits
     *  - local = 36 bits
     *
     * @param  int $id
     * @return array
     */
    public static function decode(int $id): array
    {
        $shard = ($id >> 46) & 0xFFFF;      // 16 bits
        $table = ($id >> 36) & 0x3FF;       // 10 bits
        $local = ($id >>  0) & 0xFFFFFFFFF; // 36 bits

        return [$shard, $table, $local];
    }
}
