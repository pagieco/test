<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AssetFolder;
use Faker\Generator as Faker;

$factory->define(AssetFolder::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
    ];
});
