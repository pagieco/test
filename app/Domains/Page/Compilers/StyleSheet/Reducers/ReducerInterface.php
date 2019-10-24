<?php

namespace App\Domains\Page\Compilers\StyleSheet\Reducers;

interface ReducerInterface
{
    public static function reduce(array $rules): ?string;
}
