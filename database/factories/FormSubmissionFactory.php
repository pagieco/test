<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Domains\Form\Models\Form;
use App\Domains\Profile\Models\Profile;
use App\Domains\Form\Models\FormSubmission;

$factory->define(FormSubmission::class, function (Faker $faker) {
    $form = factory(Form::class)->create();

    return [
        'form_id' => (int) $form->id,
        'profile_id' => factory(Profile::class)->create([
            'project_id' => $form->project_id,
        ]),
        'project_id' => $form->project_id,
        'submission_data' => [],
    ];
});
