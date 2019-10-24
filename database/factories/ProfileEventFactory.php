<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Profile\Models\Profile;
use App\Domains\Profile\Models\ProfileEvent;
use App\Domains\Profile\Enums\ProfileEventType;

$factory->define(ProfileEvent::class, function (Faker $faker) {
    $profile = factory(Profile::class)->create();

    return [
        'profile_id' => $profile->local_id,
        'project_id' => $profile->project_id,
        'event_type' => ProfileEventType::randomValue(),
    ];
});
