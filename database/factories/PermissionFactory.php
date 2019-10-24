<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Auth\Models\Permission;

$factory->define(Permission::class, function (Faker $faker) {
    $name = $faker->domainWord;

    return [
        'slug' => \Illuminate\Support\Str::slug($name),
        'name' => $name,
        'description' => $faker->text,
    ];
});
