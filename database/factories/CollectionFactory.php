<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Domains\Project\Models\Project;
use App\Domains\Collection\Models\Collection;

$factory->define(Collection::class, function (Faker $faker) {
    $name = $faker->domainWord;

    return [
        'project_id' => factory(Project::class)->create()->id,
        'name' => $name,
        'slug' => Str::slug($name),
    ];
});
