<?php

namespace App\Compilers\StyleSheet;

use App\Compilers\CompilerInterface;
use App\Compilers\StyleSheet\Reducers\MediaQueryReducer;

class StylesheetCompiler implements CompilerInterface
{
    public function compile($source): string
    {
        return trim(MediaQueryReducer::reduce($source));
    }
}
