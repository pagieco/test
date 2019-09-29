<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'hash' => $faker->uuid,
        'user_id' => factory(User::class)->create(),
    ];
});
