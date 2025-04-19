<?php

use App\Validators\IsInteger;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IsInteger::class)]
final class IsIntegerTest extends TestCase
{
    private IsInteger $validator;

    protected function setUp(): void
    {
        $this->validator = new IsInteger();
    }

    public function testShouldValidatePositiveInteger(): void
    {
        $result = $this->validator->validate('123');
        $this->assertTrue($result);
    }

    public function testShouldValidateNegativeInteger(): void
    {
        $result = $this->validator->validate('-456');
        $this->assertTrue($result);
    }

    public function testShouldValidateZero(): void
    {
        $result = $this->validator->validate('0');
        $this->assertTrue($result);
    }

    public function testShouldNotValidateDecimalNumber(): void
    {
        $result = $this->validator->validate('123.45');
        $this->assertFalse($result);
    }

    public function testShouldNotValidateText(): void
    {
        $result = $this->validator->validate('abc');
        $this->assertFalse($result);
    }

    public function testShouldNotValidateEmptyString(): void
    {
        $result = $this->validator->validate('');
        $this->assertFalse($result);
    }

    public function testShouldNotValidateNull(): void
    {
        $result = $this->validator->validate(null);
        $this->assertFalse($result);
    }
}
