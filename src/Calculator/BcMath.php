<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm\Calculator;

use Haeckel\BasicDecArithm\{CalculatorInterface, CmpResult, DecimalNum};

class BcMath implements CalculatorInterface
{
    public function add(
        DecimalNum $augend,
        DecimalNum $addend,
        ?int $scale = null,
    ): DecimalNum {
        $scale ??= $this->getMaxScale($augend, $addend);
        return new DecimalNum(
            \bcadd($augend->value, $addend->value, $scale),
        );
    }

    public function sub(
        DecimalNum $minuend,
        DecimalNum $subtrahend,
        ?int $scale = null,
    ): DecimalNum {
        $scale ??= $this->getMaxScale($minuend, $subtrahend);
        return new DecimalNum(
            \bcsub((string) $minuend, (string) $subtrahend, $scale),
        );
    }

    public function mul(
        DecimalNum $multiplier,
        DecimalNum $multiplicand,
        ?int $scale = null,
    ): DecimalNum {
        $scale ??= $this->getMaxScale($multiplier, $multiplicand);
        return new DecimalNum(
            \bcmul((string) $multiplier, (string) $multiplicand, $scale),
        );
    }

    public function div(
        DecimalNum $dividend,
        DecimalNum $divisor,
        ?int $scale = null,
    ): DecimalNum {
        $scale ??= $this->getMaxScale($dividend, $divisor);
        return new DecimalNum(
            \bcdiv((string) $dividend, (string) $divisor, $scale),
        );
    }

    public function mod(
        DecimalNum $dividend,
        DecimalNum $divisor,
        ?int $scale = null,
    ): DecimalNum {
        $scale ??= $this->getMaxScale($dividend, $divisor);
        return new DecimalNum(
            \bcmod((string) $dividend, (string) $divisor, $scale),
        );
    }

    public function sum(DecimalNum ...$values): DecimalNum
    {
        $scale = $this->getMaxScale(...$values);
        $sum = '0';
        foreach ($values as $value) {
            $sum = \bcadd($sum, $value->value, $scale);
        }

        return new DecimalNum($sum);
    }

    public function diff(
        DecimalNum $minuend,
        DecimalNum ...$subtrahends,
    ): DecimalNum {
        $scale = $this->getMaxScale(...[$minuend, ...$subtrahends]);
        $diff = $minuend->value;
        foreach ($subtrahends as $subtrahend) {
            $diff = \bcsub((string) $minuend, (string) $subtrahend, $scale);
        }

        return new DecimalNum($diff);
    }

    public function compareTo(DecimalNum $a, DecimalNum $b): CmpResult
    {
        $res = \bccomp(
            $a->value,
            $b->value,
            $this->getMaxScale($a, $b),
        );
        return CmpResult::fromInt($res);
    }

    private function getMaxScale(DecimalNum ...$numbers): int
    {
        $maxScale = $numbers[0]->scale;
        foreach ($numbers as $number) {
            if ($number->scale > $maxScale) {
                $maxScale = $number->scale;
            }
        }

        return $maxScale;
    }
}
