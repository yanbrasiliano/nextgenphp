<?php

use App\Validators\IsGreaterThan;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(IsGreaterThan::class)]
final class IsGreaterThanTest extends TestCase
{
    public function testShouldValidateNumberGreaterThanThreshold(): void
    {
        $validator = new IsGreaterThan(100);
        $result = $validator->validate(150);
        $this->assertTrue($result);
    }

    public function testShouldNotValidateNumberEqualToThreshold(): void
    {
        $validator = new IsGreaterThan(100);
        $result = $validator->validate(100);
        $this->assertFalse($result);
    }

    public function testShouldNotValidateNumberLessThanThreshold(): void
    {
        $validator = new IsGreaterThan(100);
        $result = $validator->validate(50);
        $this->assertFalse($result);
    }

    public function testShouldValidateStringNumberGreaterThanThreshold(): void
    {
        $validator = new IsGreaterThan(100);
        $result = $validator->validate('150');
        $this->assertTrue($result);
    }

    public function testShouldValidateNegativeThreshold(): void
    {
        $validator = new IsGreaterThan(-10);
        $result = $validator->validate(0);
        $this->assertTrue($result);
    }

    public function testShouldHandleConstructorWithDifferentThresholds(): void
    {
        $validator1 = new IsGreaterThan(0);
        $validator2 = new IsGreaterThan(1000);

        $this->assertTrue($validator1->validate(1));
        $this->assertFalse($validator2->validate(500));
    }
}
