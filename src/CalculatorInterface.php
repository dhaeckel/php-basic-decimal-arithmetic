<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic;

interface CalculatorInterface
{
    public function add(
        DecimalNumInterface $augend,
        DecimalNumInterface $addend,
    ): DecimalNumInterface;

    public function sub(
        DecimalNumInterface $minuend,
        DecimalNumInterface $subtrahend,
    ): DecimalNumInterface;

    public function mul(
        DecimalNumInterface $multiplier,
        DecimalNumInterface $multiplicand,
    ): DecimalNumInterface;

    public function div(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
    ): DecimalNumInterface;

    public function sum(
        DecimalNumInterface ...$values,
    ): DecimalNumInterface;

    public function diff(
        DecimalNumInterface $minuend,
        DecimalNumInterface ...$subtrahends,
    ): DecimalNumInterface;

    public function mod(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
    ): DecimalNumInterface;

    public function compareTo(
        DecimalNumInterface $lhs,
        DecimalNumInterface $rhs,
    ): CmpResult;

    public function pow(
        DecimalNumInterface $base,
        int $exponent,
    ): DecimalNumInterface;
}
