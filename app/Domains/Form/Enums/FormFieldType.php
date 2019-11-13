<?php

namespace App\Domains\Form\Enums;

use App\Models\Enums\Enum;

final class FormFieldType extends Enum
{
    public const PlainText = 'plain-text';
    public const URL = 'url';
    public const Email = 'email';
    public const Phone = 'phone';
    public const Number = 'number';
    public const DateTime = 'date-time';
    public const Switch = 'switch';
    public const Option = 'option';
}
