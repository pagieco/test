<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\AssetFolder;
use Faker\Generator as Faker;

$factory->define(AssetFolder::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'name' => $faker->domainWord,
    ];
});
