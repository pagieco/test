<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\WorkflowStep;
use Faker\Generator as Faker;

$factory->define(WorkflowStep::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
    ];
});
