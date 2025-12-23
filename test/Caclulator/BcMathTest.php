<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm\Test\Calculator;

use Haeckel\BasicDecArithm\{Calculator, CmpResult, DecimalNum, LegacyRoundMode};
use Haeckel\TypeWrapper\NonNegativeInt;
use PHPUnit\Framework\Attributes\{CoversClass, UsesClass};
use PHPUnit\Framework\TestCase;

#[CoversClass(Calculator\BcMath::class)]
#[UsesClass(DecimalNum::class)]
#[UsesClass(CmpResult::class)]
class BcMathTest extends TestCase
{
    public function testAdd(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(1));

        $res = (string) $calculator->add(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('0.3', $res);
    }

    public function testSub(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(1));

        $res = (string) $calculator->sub(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('0.1', $res);
    }

    public function testMul(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->mul(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );
        $this->assertEquals('0.02', $res);
    }

    public function testDiv(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->div(
            new DecimalNum('0.2'),
            new DecimalNum('0.1'),
        );

        $this->assertEquals('2.00', $res);
    }

    public function testCompareTo(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));
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
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->mod(
            new DecimalNum('5.5'),
            new DecimalNum('2'),
        );

        $this->assertEquals('1.50', $res);
    }

    public function testSum(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->sum(
            new DecimalNum('1.1'),
            new DecimalNum('2.2'),
            new DecimalNum('3.3'),
        );

        $this->assertEquals('6.60', $res);
    }

    public function testDiff(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->diff(
            new DecimalNum('10.0'),
            new DecimalNum('1.1'),
            new DecimalNum('2.2'),
            new DecimalNum('2.3'),
        );

        $this->assertEquals('4.40', $res);
    }

    public function testDiffWithNoSubtrahends(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->diff(new DecimalNum('10.0'));

        $this->assertEquals('10.00', $res);
    }

    public function testDiffWithOneSubtrahend(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->diff(
            new DecimalNum('10.0'),
            new DecimalNum('5.3'),
            new DecimalNum('4'),
        );

        $this->assertEquals('0.70', $res);
    }

    public function testSumWithoutArgs(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->sum();

        $this->assertEquals('0.00', $res);
    }

    public function testIsAccurateWithFloat(): void
    {
        $calculator = new Calculator\BcMath(new NonNegativeInt(2));

        $res = (string) $calculator->add(
            DecimalNum::fromFloat(0.1, new NonNegativeInt(1)),
            DecimalNum::fromFloat(0.2, new NonNegativeInt(1)),
        );

        $this->assertEquals('0.30', $res);
    }

    // taken from https://github.com/openjdk/jdk/blob/master/test/jdk/java/math/BigDecimal/AddTests.java
    public function testIsAccurateWithIntMax()
    {
        $num = DecimalNum::fromInt(\PHP_INT_MAX);
        $calculator = new Calculator\BcMath(new NonNegativeInt(0));

        $res = $calculator->add($num, $num);

        /** @link https://www.wolframalpha.com/input?i=%282%5E63-1%29+*+2 */
        $this->assertEquals('18446744073709551614', $res->val());
    }

    public function isAccurateWithAddingNegativeIntMax()
    {
        $num = DecimalNum::fromInt(\PHP_INT_MAX);
        $num2 = DecimalNum::fromInt(-\PHP_INT_MAX);
        $calculator = new Calculator\BcMath(new NonNegativeInt(0));

        $res = $calculator->add($num, $num2);

        /** @link https://www.wolframalpha.com/input?i=2%5E63-1+%2B+-2%5E63 */
        $this->assertEquals('-1', $res->val());
    }

    public function testIsAccurateWithIntMin()
    {
        $num = DecimalNum::fromInt(\PHP_INT_MIN);
        $calculator = new Calculator\BcMath(new NonNegativeInt(0));

        $res = $calculator->add($num, $num);

        /** @link https://www.wolframalpha.com/input?i=%28-2+%5E+63%29+*+2 */
        $this->assertEquals('-18446744073709551616', $res->val());
    }

    public function testWorksWithMultipleCalculations()
    {
        $calc = new Calculator\BcMath(new NonNegativeInt(2));

        $price = new DecimalNum('19.99');
        $quantity = new DecimalNum('3');
        $taxRatePercent = DecimalNum::fromInt(19);
        $shipping = new DecimalNum('4.99');
        $itemTotal = $calc->mul($price, $quantity); // 59.97
        $total = $calc->sum($itemTotal, $shipping); // 64.96
        $netAmount = $calc->div(
            $calc->mul(
                $total,
                DecimalNum::fromInt(100),
            ),
            $calc->add(
                DecimalNum::fromInt(100),
                $taxRatePercent
            )
        ); // 10.37
        $taxAmount = $calc->sub($total, $netAmount); // 54.59

        $this->assertEquals('59.97', $itemTotal->val());
        $this->assertEquals('64.96', $total->val());
        $this->assertEquals('54.59', $netAmount->val());
        $this->assertEquals('10.37', $taxAmount->val());
    }

    public function testWorksWithHorizontalVatCalc()
    {
        $calc = new Calculator\BcMath(new NonNegativeInt(2));
        $pricePerItemNet = new DecimalNum('1.35');
        $quantity = new DecimalNum('3');
        $taxRatePercent = DecimalNum::fromInt(7);

        $vatPerItem = $calc->mul(
            $pricePerItemNet,
            $calc->div($taxRatePercent, DecimalNum::fromInt(100))
        ); // 0.09
        $pricePerItemGross = $calc->add($pricePerItemNet, $vatPerItem); // 1.44
        $vatTotal = $calc->mul($vatPerItem, $quantity); // 0.27
        $totalGross = $calc->mul($pricePerItemGross, $quantity); // 4.32

        $this->assertEquals('0.09', $vatPerItem->val());
        $this->assertEquals('1.44', $pricePerItemGross->val());
        $this->assertEquals('0.27', $vatTotal->val());
        $this->assertEquals('4.32', $totalGross->val());
    }

    public function testWorksWithVerticalVatCalc()
    {
        $calc = new Calculator\BcMath(new NonNegativeInt(2));
        $pricePerItemNet = new DecimalNum('1.35');
        $quantity = new DecimalNum('3');
        $taxRatePercent = DecimalNum::fromInt(7);

        $subtotalNet = $calc->mul($pricePerItemNet, $quantity); // 4.05
        $vatTotal = $calc->mul(
            $subtotalNet,
            $calc->div(
                $taxRatePercent,
                DecimalNum::fromInt(100),
            ),
        ); // 0.28

        $totalGross = $calc->add($subtotalNet, $vatTotal); // 4.33

        $this->assertEquals('4.33', $totalGross->val());
        $this->assertEquals('0.28', $vatTotal->val());
        $this->assertEquals('4.05', $subtotalNet->val());
    }

    public function testWithRoundModeAwayFromZero(): void
    {
        $calculator = new Calculator\BcMath(
            new NonNegativeInt(0),
            LegacyRoundMode::HalfAwayFromZero,
        );

        $res1 = (string) $calculator->div(
            new DecimalNum('1'),
            new DecimalNum('2'),
        );
        $res2 = (string) $calculator->div(
            new DecimalNum('1'),
            new DecimalNum('3'),
        );

        $this->assertEquals('1', $res1);
        $this->assertEquals('0', $res2);
    }

    public function testWithRoundModeTowardsZero(): void
    {
        $calculator = new Calculator\BcMath(
            new NonNegativeInt(0),
            LegacyRoundMode::HalfTowardsZero,
        );

        $res1 = (string) $calculator->div(
            new DecimalNum('1'),
            new DecimalNum('2'),
        );
        $res2 = (string) $calculator->div(
            new DecimalNum('1.2'),
            new DecimalNum('2'),
        );

        $this->assertEquals('0', $res1);
        $this->assertEquals('1', $res2);
    }

    public function testWithRoundHalfOdd(): void
    {
        $calculator = new Calculator\BcMath(
            new NonNegativeInt(0),
            LegacyRoundMode::HalfToOdd,
        );

        $res1 = (string) $calculator->div(
            new DecimalNum('2.5'),
            new DecimalNum('1'),
        );
        $res2 = (string) $calculator->div(
            new DecimalNum('3.5'),
            new DecimalNum('1'),
        );
        $res3 = (string) $calculator->div(
            new DecimalNum('4.4'),
            new DecimalNum('1'),
        );
        $res3 = (string) $calculator->div(
            new DecimalNum('3.6'),
            new DecimalNum('1'),
        );

        $this->assertEquals('3', $res1);
        $this->assertEquals('3', $res2);
        $this->assertEquals('4', $res3);
        $this->assertEquals('4', $res3);
    }

    public function testWithRoundHalfEven(): void
    {
        $calculator = new Calculator\BcMath(
            new NonNegativeInt(0),
            LegacyRoundMode::HalfToEven,
        );

        $res1 = (string) $calculator->div(
            new DecimalNum('2.5'),
            new DecimalNum('1'),
        );
        $res2 = (string) $calculator->div(
            new DecimalNum('3.5'),
            new DecimalNum('1'),
        );
        $res3 = (string) $calculator->div(
            new DecimalNum('3.4'),
            new DecimalNum('1'),
        );
        $res4 = (string) $calculator->div(
            new DecimalNum('2.6'),
            new DecimalNum('1'),
        );
        $res4 = (string) $calculator->div(
            new DecimalNum('1'),
            new DecimalNum('1'),
        );

        $this->assertEquals('2', $res1);
        $this->assertEquals('4', $res2);
        $this->assertEquals('3', $res3);
        $this->assertEquals('1', $res4);
    }
}
