<?php

use App\Validators\IsEven;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IsEven::class)]
final class IsEvenTest extends TestCase
{
    private IsEven $validator;

    protected function setUp(): void
    {
        $this->validator = new IsEven();
    }

    public function testShouldValidatePositiveEvenNumber(): void
    {
        $result = $this->validator->validate(2);
        $this->assertTrue($result);
    }

    public function testShouldValidateNegativeEvenNumber(): void
    {
        $result = $this->validator->validate(-4);
        $this->assertTrue($result);
    }

    public function testShouldValidateZero(): void
    {
        $result = $this->validator->validate(0);
        $this->assertTrue($result);
    }

    public function testShouldNotValidateOddNumber(): void
    {
        $result = $this->validator->validate(3);
        $this->assertFalse($result);
    }

    public function testShouldValidateStringEvenNumber(): void
    {
        $result = $this->validator->validate('6');
        $this->assertTrue($result);
    }

    public function testShouldNotValidateStringOddNumber(): void
    {
        $result = $this->validator->validate('7');
        $this->assertFalse($result);
    }

    public function testShouldNotValidateDecimalNumber(): void
    {
        $result = $this->validator->validate(2.5);
        $this->assertFalse($result);
    }

    public function testShouldNotValidateNonNumericValue(): void
    {
        $result = $this->validator->validate('abc');
        $this->assertFalse($result);
    }
}
