<?php

declare(strict_types=1);

namespace Haeckel\Math;

use Haeckel\Money\CalculatorInterface;

class BcMath implements CalculatorInterface
{
    public function add(
        DecimalNumber $augend,
        DecimalNumber $addend,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($augend, $addend);
        return new DecimalNumber(
            \bcadd($augend->value, $addend->value, $scale),
        );
    }

    public function sub(
        DecimalNumber $minuend,
        DecimalNumber $subtrahend,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($minuend, $subtrahend);
        return new DecimalNumber(
            \bcsub((string) $minuend, (string) $subtrahend, $scale),
        );
    }

    public function mul(
        DecimalNumber $multiplier,
        DecimalNumber $multiplicand,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($multiplier, $multiplicand);
        return new DecimalNumber(
            \bcmul((string) $multiplier, (string) $multiplicand, $scale),
        );
    }

    public function div(
        DecimalNumber $dividend,
        DecimalNumber $divisor,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($dividend, $divisor);
        return new DecimalNumber(
            \bcdiv((string) $dividend, (string) $divisor, $scale),
        );
    }

    public function mod(
        DecimalNumber $dividend,
        DecimalNumber $divisor,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($dividend, $divisor);
        return new DecimalNumber(
            \bcmod((string) $dividend, (string) $divisor, $scale),
        );
    }

    public function pow(
        DecimalNumber $base,
        DecimalNumber $exponent,
        ?int $scale = null,
    ): DecimalNumber {
        $scale ??= $this->getScale($base, $exponent);
        return new DecimalNumber(
            \bcpow((string) $base, (string) $exponent, $scale),
        );
    }

    public function sqrt(DecimalNumber $radicand, ?int $scale = null): DecimalNumber
    {
        $scale ??= $radicand->scale;
        return new DecimalNumber(
            \bcsqrt((string) $radicand, $scale),
        );
    }

    public function sum(DecimalNumber ...$values): DecimalNumber
    {
        $scale = $this->getScale(...$values);
        $sum = new DecimalNumber('0');
        foreach ($values as $value) {
            $sum = $this->add($sum, $value, $scale);
        }

        return $sum;
    }

    public function diff(DecimalNumber $minuend, DecimalNumber ...$subtrahends): DecimalNumber
    {
        $scale = $this->getScale(...[$minuend, ...$subtrahends]);
        $diff = $minuend;
        foreach ($subtrahends as $subtrahend) {
            $diff = $this->sub($diff, $subtrahend, $scale);
        }

        return $diff;
    }

    public function compareTo(DecimalNumber $a, DecimalNumber $b): CmpResult
    {
        $res = \bccomp($a->value, $b->value, $this->getScale($a, $b));
        return match ($res) {
            -1 => CmpResult::LessThan,
            0 => CmpResult::Equal,
            1 => CmpResult::GreaterThan,
        };
    }

    private function getScale(DecimalNumber ...$numbers): int
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
