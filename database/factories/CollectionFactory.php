<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Project;
use App\Models\Collection;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Collection::class, function (Faker $faker) {
    $name = $faker->domainWord;

    return [
        'project_id' => factory(Project::class)->create()->id,
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
