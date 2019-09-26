<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use App\Models\ProfileEvent;
use Faker\Generator as Faker;
use App\Models\Enums\ProfileEventType;

$factory->define(ProfileEvent::class, function (Faker $faker) {
    $profile = factory(Profile::class)->create();

    return [
        'profile_id' => $profile->local_id,
        'project_id' => $profile->project_id,
        'event_type' => ProfileEventType::randomValue(),
    ];
});
