<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Project\Models\Project;
use App\Domains\Workflow\Models\WorkflowStep;

$factory->define(WorkflowStep::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
    ];
});
