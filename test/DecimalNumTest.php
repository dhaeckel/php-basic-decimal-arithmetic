<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic\Test;

use Haeckel\BasicDecimalArithmetic\DefaultDecimalNum;
use Haeckel\TypeWrapper\NonNegativeInt;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultDecimalNum::class)]
class DecimalNumTest extends TestCase
{
    public function testCreateFromValidString(): void
    {
        $num = new DefaultDecimalNum('123.456');
        $this->assertEquals('123.456', (string) $num);
    }

    public function testAcceptsScale(): void
    {
        $num = DefaultDecimalNum::fromStringWithScale(
            '123.455',
            new NonNegativeInt(2),
        );
        $this->assertEquals('123.46', $num->val());
    }

    public function testCreateFromNonNumericString(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Value must be a numeric string');
        new DefaultDecimalNum('1/2');
    }

    public function testCreateFromEmptyString(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage('Value cannot be an empty string');
        new DefaultDecimalNum('');
    }

    public function testCreateFromScientificNotationStringThrows(): void
    {
        $this->expectException(\ValueError::class);
        $this->expectExceptionMessage(
            'Value cannot be in scientific notation, '
            . 'use fromScientificNotationString. '
            . 'Given value: 1.23E3',
        );
        new DefaultDecimalNum('1.23E3');
    }

    public function testAcceptsScientificNotation(): void
    {
        $num = DefaultDecimalNum::fromScientificNotationString(
            '1.23E3',
            new NonNegativeInt(2),
        );
        $this->assertEquals(
            \sprintf('%.2F', \round((float) '1.23E3', 2)),
            $num->val(),
        );
    }

    public function testAcceptsFloatMax(): void
    {
        $num = DefaultDecimalNum::fromFloat(
            \PHP_FLOAT_MAX,
            new NonNegativeInt(14),
        );
        $this->assertEquals(\sprintf('%.14F', \PHP_FLOAT_MAX), $num->val());
    }

    public function testAcceptsFloatMin(): void
    {
        $num = DefaultDecimalNum::fromFloat(
            \PHP_FLOAT_MIN,
            new NonNegativeInt(20),
        );
        $this->assertEquals(
            \sprintf('%.20F', \round(\PHP_FLOAT_MIN, 20)),
            $num->val()
        );
    }

    public function testAcceptsIntMax(): void
    {
        $num = DefaultDecimalNum::fromInt(\PHP_INT_MAX);
        $this->assertEquals((string) \PHP_INT_MAX, $num->val());
    }

    public function testAcceptsIntMin(): void
    {
        $num = DefaultDecimalNum::fromInt(\PHP_INT_MIN);
        $this->assertEquals((string) \PHP_INT_MIN, $num->val());
    }
}
