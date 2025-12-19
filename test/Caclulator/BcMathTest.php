<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm\Test\Calculator;

use Haeckel\BasicDecArithm\{Calculator, CmpResult, DecimalNum};
use Haeckel\TypeWrapper\PositiveInt;
use PHPUnit\Framework\Attributes\{CoversClass, UsesClass};
use PHPUnit\Framework\TestCase;

#[CoversClass(Calculator\BcMath::class)]
#[UsesClass(DecimalNum::class)]
#[UsesClass(CmpResult::class)]
class BcMathTest extends TestCase
{
    public function testAdd(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(1));

        $res = (string) $calculator->add(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('0.3', $res);
    }

    public function testSub(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(1));

        $res = (string) $calculator->sub(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('0.1', $res);
    }

    public function testMul(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->mul(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );
        $this->assertEquals('0.02', $res);
    }

    public function testDiv(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->div(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('2.00', $res);
    }

    public function testCompareTo(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));
        $this->assertEquals(
            CmpResult::GreaterThan,
            $calculator->compareTo(
                new DecimalNum('0.2'),
                new DecimalNum('0.1'),
            ),
        );
        $this->assertEquals(
            CmpResult::Equal,
            $calculator->compareTo(
                new DecimalNum('0.1'),
                new DecimalNum('0.1'),
            ),
        );
        $this->assertEquals(
            CmpResult::LessThan,
            $calculator->compareTo(
                new DecimalNum('0.1'),
                new DecimalNum('0.2'),
            ),
        );
    }

    public function testMod(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->mod(
            new DecimalNum('5.5'),
            new DecimalNum('2'),
        );

        $this->assertEquals('1.50', $res);
    }

    public function testSum(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->sum(
            null,
            new DecimalNum('1.1'),
            new DecimalNum('2.2'),
            new DecimalNum('3.3'),
        );

        $this->assertEquals('6.60', $res);
    }

    public function testDiff(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->diff(
            null,
            new DecimalNum('10.0'),
            new DecimalNum('1.1'),
            new DecimalNum('2.2'),
            new DecimalNum('2.3'),
        );

        $this->assertEquals('4.40', $res);
    }

    public function testDiffWithNoSubtrahends(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->diff(null, new DecimalNum('10.0'));

        $this->assertEquals('10.00', $res);
    }

    public function testDiffWithOneSubtrahend(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->diff(
            null,
            new DecimalNum('10.0'),
            new DecimalNum('5.3'),
            new DecimalNum('4'),
        );

        $this->assertEquals('0.70', $res);
    }

    public function testSumWithoutArgs(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(2));

        $res = (string) $calculator->sum(null);

        $this->assertEquals('0.00', $res);
    }

    public function testIsAccurateWithFloat(): void
    {
        $calculator = new Calculator\BcMath(new PositiveInt(1));

        $res = (string) $calculator->add(
            DecimalNum::fromFloat(0.1, new PositiveInt(1)),
            DecimalNum::fromFloat(0.2, new PositiveInt(1)),
        );

        $this->assertEquals('0.3', $res);
    }
}
