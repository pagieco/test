<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'name' => $faker->domainWord,
        'description' => $faker->text,
    ];
});
