<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Email\Models\Email;
use App\Domains\Project\Models\Project;

$factory->define(Email::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'name' => $faker->name,
    ];
});
