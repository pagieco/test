<?php

namespace App\Domains\Page\Compilers\StyleSheet\Reducers;

class SelectorReducer implements ReducerInterface
{
    public static function reduce(array $rules): ?string
    {
        $selectors = array_keys($rules);

        return array_reduce($selectors, static function ( $carry, $item) use ($rules) {
            $properties = PropertyReducer::reduce($rules[$item]);

            return sprintf('%s%s{%s}', $carry, $item, $properties);
        });
    }
}
