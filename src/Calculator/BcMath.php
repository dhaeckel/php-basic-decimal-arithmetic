<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm\Calculator;

use Haeckel\BasicDecArithm\{
    CalculatorInterface,
    CmpResult,
    DecimalNum,
    DecimalNumInterface,
};
use Haeckel\TypeWrapper\PositiveInt;

class BcMath implements CalculatorInterface
{
    private int $scale;

    public function __construct(PositiveInt $scale)
    {
        $this->scale = $scale->toInt();
    }

    public function add(
        DecimalNumInterface $augend,
        DecimalNumInterface $addend,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        return new DecimalNum(
            \bcadd($augend->val(), $addend->val(), $scale),
        );
    }

    public function sub(
        DecimalNumInterface $minuend,
        DecimalNumInterface $subtrahend,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        return new DecimalNum(
            \bcsub($minuend->val(), $subtrahend->val(), $scale),
        );
    }

    public function mul(
        DecimalNumInterface $multiplier,
        DecimalNumInterface $multiplicand,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        return new DecimalNum(
            \bcmul($multiplier->val(), $multiplicand->val(), $scale),
        );
    }

    public function div(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        return new DecimalNum(
            \bcdiv($dividend->val(), $divisor->val(), $scale),
        );
    }

    public function mod(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        return new DecimalNum(
            \bcmod($dividend->val(), $divisor->val(), $scale),
        );
    }

    public function sum(
        ?PositiveInt $scale,
        DecimalNumInterface ...$values,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        $sum = \bcadd('0', '0', $scale); // to ensure proper scale
        foreach ($values as $value) {
            $sum = \bcadd($sum, $value->val(), $scale);
        }

        return new DecimalNum($sum);
    }

    public function diff(
        ?PositiveInt $scale,
        DecimalNumInterface $minuend,
        DecimalNumInterface ...$subtrahends,
    ): DecimalNumInterface {
        $scale = $scale?->toInt() ?? $this->scale;
        $diff = \bcadd($minuend->val(), '0', $scale); // to ensure proper scale
        foreach ($subtrahends as $subtrahend) {
            $diff = \bcsub($diff, $subtrahend->val(), $scale);
        }

        return new DecimalNum($diff);
    }

    public function compareTo(
        DecimalNumInterface $lhs,
        DecimalNumInterface $rhs,
        ?PositiveInt $scale = null,
    ): CmpResult {
        $res = \bccomp(
            $lhs->val(),
            $rhs->val(),
            $scale = $scale?->toInt() ?? $this->scale,
        );
        return CmpResult::fromInt($res);
    }
}
