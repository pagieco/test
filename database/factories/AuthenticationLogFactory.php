<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;
use App\Models\AuthenticationLog;

$factory->define(AuthenticationLog::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'ip_address' => faker()->ipv4,
        'user_agent' => faker()->userAgent,
        'logged_in_at' => faker()->dateTime,
        'logged_out_at' => faker()->dateTime,
    ];
});
