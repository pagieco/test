<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Page;
use App\Models\Domain;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    $project = factory(Project::class)->create();

    return [
        'project_id' => $project->id,
        'domain_id' => factory(Domain::class)->create([
            'project_id' => $project->id,
        ]),
        'name' => $faker->name,
        'slug' => $faker->slug,
    ];
});
