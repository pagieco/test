<?php

namespace App\Domains\Collection\Enums;

use App\Models\Enums\Enum;

final class CollectionFieldValidation extends Enum
{
    const Required = 'required';
    const Email = 'email';
}
