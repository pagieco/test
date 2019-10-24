<?php

namespace App\Domains\Form\Enums;

use App\Models\Enums\Enum;

final class FormFieldType extends Enum
{
    const PlainText = 'plain-text';
    const URL = 'url';
    const Email = 'email';
    const Phone = 'phone';
    const Number = 'number';
    const DateTime = 'date-time';
    const Switch = 'switch';
    const Option = 'option';
}
