<?php

namespace App\Domains\Page\Compilers\StyleSheet\Reducers;

class PropertyReducer implements ReducerInterface
{
    public static function reduce(array $rules): ?string
    {
        $properties = array_keys($rules);

        return array_reduce($properties, static function ( $carry, $item) use ($rules) {
            return sprintf('%s%s:%s', $carry, $item, $rules[$item]);
        });
    }
}
