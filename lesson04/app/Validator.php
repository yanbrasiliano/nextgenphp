<?php

namespace App;

use App\Interfaces\ValidatorInterface;
use App\Validators\IsInteger;
use App\Validators\IsGreaterThan;
use App\Validators\IsEven;

class Validator
{
    private $validations = [];

    public static function validateInteger($value): bool
    {
        $validator = new IsInteger();
        return $validator->validate($value);
    }

    public static function validateGreaterThan($value, $threshold): bool
    {
        $validator = new IsGreaterThan($threshold);
        return $validator->validate($value);
    }

    public static function validateEven($value): bool
    {
        $validator = new IsEven();
        return $validator->validate($value);
    }

    public function addValidation(ValidatorInterface $validation): self
    {
        $this->validations[] = $validation;
        return $this;
    }
    public function validate($value): bool
    {
        foreach ($this->validations as $validation) {
            if (!$validation->validate($value)) {
                return false;
            }
        }

        return true;
    }
}
