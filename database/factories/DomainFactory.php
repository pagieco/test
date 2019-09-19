<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Domain;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Domain::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'domain_name' => $faker->domainName,
    ];
});
