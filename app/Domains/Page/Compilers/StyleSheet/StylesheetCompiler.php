<?php

namespace App\Domains\Page\Compilers\StyleSheet;

use App\Domains\Page\Compilers\CompilerInterface;
use App\Domains\Page\Compilers\StyleSheet\Reducers\MediaQueryReducer;

class StylesheetCompiler implements CompilerInterface
{
    public function compile($source): string
    {
        return trim(MediaQueryReducer::reduce($source));
    }
}
