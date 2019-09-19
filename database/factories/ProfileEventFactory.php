<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Profile;
use App\Models\ProfileEvent;
use Faker\Generator as Faker;
use App\Models\Enums\ProfileEventType;

$factory->define(ProfileEvent::class, function (Faker $faker) {
    $events = ProfileEventType::getValues();

    return [
        'profile_id' => factory(Profile::class)->create()->id,
        'event_type' => array_rand($events),
    ];
});
