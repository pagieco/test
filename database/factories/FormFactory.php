<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Form\Models\Form;
use App\Domains\Project\Models\Project;

$factory->define(Form::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'name' => $faker->name,
    ];
});
