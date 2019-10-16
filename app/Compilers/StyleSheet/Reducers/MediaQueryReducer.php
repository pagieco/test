<?php

namespace App\Compilers\StyleSheet\Reducers;

class MediaQueryReducer implements ReducerInterface
{
    public static function reduce(array $rules): ?string
    {
        $queries = array_keys($rules);

        return array_reduce($queries, function ($carry, $item) use ($rules) {
            $selectors = SelectorReducer::reduce($rules[$item]);

            return sprintf('%s @media %s{%s}', $carry, $item, $selectors);
        });
    }
}
