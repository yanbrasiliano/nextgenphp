<?php

use App\Validator;
use App\Validators\IsEven;
use App\Validators\IsGreaterThan;
use App\Validators\IsInteger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Validator::class)]
#[UsesClass(IsInteger::class)]
#[UsesClass(IsGreaterThan::class)]
#[UsesClass(IsEven::class)]
final class ValidatorTest extends TestCase
{
    public function testClassValidatorShouldValidateIsInteger(): void
    {
        $result = Validator::validateInteger('1');
        $this->assertTrue($result);

        $result = Validator::validateInteger('-2');
        $this->assertTrue($result);
    }

    public function testClassValidatorShouldValidateIsNotInteger(): void
    {
        $result = Validator::validateInteger('123.22');
        $this->assertFalse($result);
    }

    public function testClassValidatorShouldValidateMultipleValidations(): void
    {
        $value = '302';
        $result1 = Validator::validateInteger($value);
        $result2 = Validator::validateGreaterThan($value, 200);
        $result3 = Validator::validateEven($value);

        $this->assertTrue($result1 && $result2 && $result3);
    }

    public function testClassValidatorShouldAggregateMultipleValidations(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $result = $validationGroup->validate(302);

        $this->assertTrue($result);
    }

    public function testClassValidatorShouldFailWhenValueIsNotInteger(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $result = $validationGroup->validate("abc");

        $this->assertFalse($result);
    }

    public function testClassValidatorShouldFailWhenValueIsNotGreaterThan(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $result = $validationGroup->validate(100);

        $this->assertFalse($result);
    }

    public function testClassValidatorShouldFailWhenValueIsNotEven(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $result = $validationGroup->validate(301);

        $this->assertFalse($result);
    }
}
