<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Project\Models\Project;
use App\Domains\Profile\Models\Profile;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'project_id' => factory(Project::class)->create(),
        'email' => $faker->email,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'address_1' => $faker->address,
        'address_2' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->citySuffix,
        'zip' => $faker->postcode,
        'country' => $faker->country,
        'phone' => $faker->phoneNumber,
        'timezone' => $faker->timezone,
    ];
});
