<?php

namespace App\Validators;

use App\Interfaces\ValidatorInterface;

class IsInteger implements ValidatorInterface
{
    public function validate($value): bool
    {
        return is_numeric($value) && (string) (int) $value === (string) $value;
    }
}
