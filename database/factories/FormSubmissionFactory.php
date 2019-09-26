<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Form;
use Faker\Generator as Faker;
use App\Models\FormSubmission;

$factory->define(FormSubmission::class, function (Faker $faker) {
    $form = factory(Form::class)->create();

    return [
        'form_id' => (int) $form->id,
        'project_id' => $form->project_id,
        'submission_data' => [],
    ];
});
