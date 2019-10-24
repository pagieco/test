<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Project\Models\Project;
use App\Domains\Asset\Models\AssetFolder;

$factory->define(AssetFolder::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'name' => $faker->domainWord,
    ];
});
