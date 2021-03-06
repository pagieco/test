<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Collection\Models\Collection;
use App\Domains\Collection\Models\CollectionEntry;

$factory->define(CollectionEntry::class, function (Faker $faker) {
    $collection = factory(Collection::class)->create();

    return [
        'project_id' => $collection->project_id,
        'collection_id' => $collection->local_id,
        'slug' => $faker->slug,
        'name' => $faker->name,
        'entry_data' => [],
    ];
});
