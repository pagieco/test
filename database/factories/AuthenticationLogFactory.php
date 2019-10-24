<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\User\Models\User;
use App\Domains\Auth\Models\AuthenticationLog;

$factory->define(AuthenticationLog::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'ip_address' => faker()->ipv4,
        'user_agent' => faker()->userAgent,
        'logged_in_at' => faker()->dateTime,
        'logged_out_at' => faker()->dateTime,
    ];
});
