<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Email;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'name' => $faker->name,
    ];
});
