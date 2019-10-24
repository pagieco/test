<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Page\Models\Page;
use App\Domains\Domain\Models\Domain;
use App\Domains\Project\Models\Project;

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
