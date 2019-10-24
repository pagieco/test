<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Domain\Models\Domain;
use App\Domains\Project\Models\Project;

$factory->define(Domain::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create()->id,
        'domain_name' => $faker->domainName,
        'timezone' => $faker->timezone,
    ];
});
