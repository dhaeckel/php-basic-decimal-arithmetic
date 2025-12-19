<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

use Haeckel\TypeWrapper\NonNegativeInt;

interface CalculatorInterface
{
    public function add(
        DecimalNumInterface $augend,
        DecimalNumInterface $addend,
        ?NonNegativeInt $scale = null,
    ): DecimalNumInterface;

    public function sub(
        DecimalNumInterface $minuend,
        DecimalNumInterface $subtrahend,
        ?NonNegativeInt $scale = null,
    ): DecimalNumInterface;

    public function mul(
        DecimalNumInterface $multiplier,
        DecimalNumInterface $multiplicand,
        ?NonNegativeInt $scale = null,
    ): DecimalNumInterface;

    public function div(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?NonNegativeInt $scale = null,
    ): DecimalNumInterface;

    public function sum(
        ?NonNegativeInt $scale,
        DecimalNumInterface ...$values,
    ): DecimalNumInterface;

    public function diff(
        ?NonNegativeInt $scale,
        DecimalNumInterface $minuend,
        DecimalNumInterface ...$subtrahends,
    ): DecimalNumInterface;

    public function mod(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?NonNegativeInt $scale = null,
    ): DecimalNumInterface;

    public function compareTo(
        DecimalNumInterface $lhs,
        DecimalNumInterface $rhs,
        ?NonNegativeInt $scale = null,
    ): CmpResult;
}
