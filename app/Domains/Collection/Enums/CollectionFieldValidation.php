<?php

namespace App\Domains\Collection\Enums;

use App\Models\Enums\Enum;

final class CollectionFieldValidation extends Enum
{
    public const Required = 'required';
    public const Email = 'email';
}
