<?php

namespace Tests\Integration;

use App\Validator;
use App\Validators\IsInteger;
use App\Validators\IsGreaterThan;
use App\Validators\IsEven;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Validator::class)]
#[CoversClass(IsInteger::class)]
#[CoversClass(IsGreaterThan::class)]
#[CoversClass(IsEven::class)]
final class ValidatorIntegrationTest extends TestCase
{
    public function testShouldValidateWithMultipleValidations(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $this->assertTrue($validationGroup->validate(302));
        $this->assertTrue($validationGroup->validate('304'));
    }

    public function testShouldFailValidationWhenAnyValidatorFails(): void
    {
        $validator = new Validator();

        $validationGroup = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
        ;

        $this->assertFalse($validationGroup->validate("abc"));
        $this->assertFalse($validationGroup->validate("123.45"));

        $this->assertFalse($validationGroup->validate(100));
        $this->assertFalse($validationGroup->validate('150'));

        $this->assertFalse($validationGroup->validate(301));
        $this->assertFalse($validationGroup->validate('203'));
    }

    public function testShouldProduceSameResultWithStaticAndChainedMethods(): void
    {
        $value = '302';
        $staticResult1 = Validator::validateInteger($value);
        $staticResult2 = Validator::validateGreaterThan($value, 200);
        $staticResult3 = Validator::validateEven($value);

        $staticCombinedResult = $staticResult1 && $staticResult2 && $staticResult3;

        $validator = new Validator();
        $chainedResult = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
            ->validate($value)
        ;

        $this->assertEquals($staticCombinedResult, $chainedResult);
        $this->assertTrue($chainedResult);

        $invalidValue = '301';

        $staticInvalidResult1 = Validator::validateInteger($invalidValue);
        $staticInvalidResult2 = Validator::validateGreaterThan($invalidValue, 200);
        $staticInvalidResult3 = Validator::validateEven($invalidValue);

        $staticCombinedInvalidResult = $staticInvalidResult1 && $staticInvalidResult2 && $staticInvalidResult3;

        $chainedInvalidResult = $validator
            ->addValidation(new IsInteger())
            ->addValidation(new IsGreaterThan(200))
            ->addValidation(new IsEven())
            ->validate($invalidValue)
        ;

        $this->assertEquals($staticCombinedInvalidResult, $chainedInvalidResult);
        $this->assertFalse($chainedInvalidResult);
    }


    public function testShouldStopValidationOnFirstFailure(): void
    {
        $integerValidator = $this->createMock(IsInteger::class);
        $greaterThanValidator = $this->createMock(IsGreaterThan::class);
        $evenValidator = $this->createMock(IsEven::class);

        $integerValidator->method('validate')->willReturn(false);

        $greaterThanValidator->expects($this->never())->method('validate');
        $evenValidator->expects($this->never())->method('validate');

        $validator = new Validator();
        $validationGroup = $validator
            ->addValidation($integerValidator)
            ->addValidation($greaterThanValidator)
            ->addValidation($evenValidator)
        ;

        $result = $validationGroup->validate("abc");
        $this->assertFalse($result);
    }


    public function testShouldApplyValidatorsInCorrectOrder(): void
    {
        $callOrder = [];

        $integerValidator = $this->createMock(IsInteger::class);
        $integerValidator->method('validate')
            ->willReturnCallback(function ($value) use (&$callOrder) {
                $callOrder[] = 'integer';
                return true;
            });

        $greaterThanValidator = $this->createMock(IsGreaterThan::class);
        $greaterThanValidator->method('validate')
            ->willReturnCallback(function ($value) use (&$callOrder) {
                $callOrder[] = 'greaterThan';
                return true;
            });

        $evenValidator = $this->createMock(IsEven::class);
        $evenValidator->method('validate')
            ->willReturnCallback(function ($value) use (&$callOrder) {
                $callOrder[] = 'even';
                return true;
            });

        $validator = new Validator();
        $validationGroup = $validator
            ->addValidation($integerValidator)
            ->addValidation($greaterThanValidator)
            ->addValidation($evenValidator)
        ;

        $result = $validationGroup->validate(302);
        $this->assertTrue($result);

        $this->assertEquals(['integer', 'greaterThan', 'even'], $callOrder);
    }
}
