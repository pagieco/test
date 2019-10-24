<?php

namespace App\Domains\Form\Enums;

use App\Models\Enums\Enum;

final class FormFieldValidation extends Enum
{
    const Required = 'required';
    const Email = 'email';
}
