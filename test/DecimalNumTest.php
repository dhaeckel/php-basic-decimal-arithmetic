<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm\Test;

use Haeckel\BasicDecArithm\DecimalNum;
use Haeckel\TypeWrapper\NonNegativeInt;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DecimalNum::class)]
class DecimalNumTest extends TestCase
{
    public function testCreateFromValidString(): void
    {
        $num = new DecimalNum('123.456');
        $this->assertEquals('123.456', (string) $num);
    }

    public function testAcceptsScale(): void
    {
        $num = DecimalNum::fromStringWithScale('123.455', new NonNegativeInt(2));
        $this->assertEquals('123.46', $num->val());
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new DecimalNum('1/2');
    }

    public function testAcceptsScientificNotation(): void
    {
        $num = DecimalNum::fromScientificNotationString(
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
        $num = DecimalNum::fromFloat(\PHP_FLOAT_MAX, new NonNegativeInt(14));
        $this->assertEquals(\sprintf('%.14F', \PHP_FLOAT_MAX), $num->val());
    }

    public function testAcceptsFloatMin(): void
    {
        $num = DecimalNum::fromFloat(\PHP_FLOAT_MIN, new NonNegativeInt(20));
        $this->assertEquals(
            \sprintf('%.20F', \round(\PHP_FLOAT_MIN, 20)),
            $num->val()
        );
    }

    public function testAcceptsIntMax(): void
    {
        $num = DecimalNum::fromInt(\PHP_INT_MAX);
        $this->assertEquals((string) \PHP_INT_MAX, $num->val());
    }

    public function testAcceptsIntMin(): void
    {
        $num = DecimalNum::fromInt(\PHP_INT_MIN);
        $this->assertEquals((string) \PHP_INT_MIN, $num->val());
    }
}
