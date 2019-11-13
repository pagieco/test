<?php

namespace App\Services;

class IdGenerator
{
    public static $shardBits = 23;

    public static $localBits = 40;

    public static function encode(int $shard, int $local): int
    {
        return ($shard << static::$localBits) | $local;
    }

    public static function decode(int $id): array
    {
        $shard = ($id >> static::$localBits) & (2 ** static::$shardBits) - 1;
        $local = $id & (2 ** static::$localBits) - 1;

        return compact('shard', 'local');
    }
}
