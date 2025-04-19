<?php

namespace App\Validators;

use App\Interfaces\ValidatorInterface;
class IsGreaterThan implements ValidatorInterface
{
    private $threshold;

    public function __construct(int $threshold)
    {
        $this->threshold = $threshold;
    }

    public function validate($value): bool
    {
        return $value > $this->threshold;
    }
}
