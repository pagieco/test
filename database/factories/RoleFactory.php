<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Auth\Models\Role;
use App\Domains\Project\Models\Project;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'name' => $faker->domainWord,
        'description' => $faker->text,
    ];
});
