<?php

namespace App\Compilers\StyleSheet\Reducers;

interface ReducerInterface
{
    public static function reduce(array $rules): ?string;
}
