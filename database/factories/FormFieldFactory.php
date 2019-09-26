<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Enums\FormFieldType;

$factory->define(FormField::class, function (Faker $faker) {
    $name = $faker->domainWord;

    $form = factory(Form::class)->create();

    return [
        'form_id' => $form->id,
        'project_id' => $form->project_id,
        'display_name' => $name,
        'slug' => Str::slug($name),
        'validations' => [],
        'type' => FormFieldType::randomValue(),
    ];
});
