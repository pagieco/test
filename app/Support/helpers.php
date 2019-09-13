<?php

use Faker\Factory as Faker;
use Faker\Generator as FakerGenerator;

if (! function_exists('faker')) {
    /**
     * Create a new faker instance.
     *
     * @param  string $locale
     * @return \Faker\Generator
     */
    function faker($locale = Faker::DEFAULT_LOCALE): FakerGenerator
    {
        return Faker::create($locale);
    }
}
