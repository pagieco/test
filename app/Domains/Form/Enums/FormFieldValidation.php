<?php

namespace App\Domains\Form\Enums;

use App\Models\Enums\Enum;

final class FormFieldValidation extends Enum
{
    public const Required = 'required';
    public const Email = 'email';
}
