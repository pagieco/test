<?php

namespace App\Domains\Page\Compilers\StyleSheet\Reducers;

class MediaQueryReducer implements ReducerInterface
{
    public static function reduce(?array $rules): ?string
    {
        $queries = array_keys($rules);

        return array_reduce($queries, static function ( $carry, $item) use ($rules) {
            if ($rules[$item]) {
                $selectors = SelectorReducer::reduce($rules[$item]);

                return sprintf('%s @media %s{%s}', $carry, $item, $selectors);
            }
        });
    }
}
