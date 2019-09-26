<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use Faker\Generator as Faker;
use App\Models\CollectionEntry;

$factory->define(CollectionEntry::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'slug' => $faker->slug,
        'name' => $faker->name,
        'entry_data' => [],
    ];
});
