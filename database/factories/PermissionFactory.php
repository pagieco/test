<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    $name = $faker->domainWord;

    return [
        'slug' => \Illuminate\Support\Str::slug($name),
        'name' => $name,
        'description' => $faker->text,
    ];
});
