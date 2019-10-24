<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\User\Models\User;
use App\Domains\Project\Models\Project;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'hash' => $faker->uuid,
        'api_token' => (new Project)->generateApiToken(),
        'user_id' => factory(User::class)->create(),
        'used_storage' => 0,
    ];
});
