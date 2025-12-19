<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

use Haeckel\TypeWrapper\PositiveInt;

interface CalculatorInterface
{
    public function add(
        DecimalNumInterface $augend,
        DecimalNumInterface $addend,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface;

    public function sub(
        DecimalNumInterface $minuend,
        DecimalNumInterface $subtrahend,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface;

    public function mul(
        DecimalNumInterface $multiplier,
        DecimalNumInterface $multiplicand,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface;

    public function div(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface;

    public function sum(
        ?PositiveInt $scale,
        DecimalNumInterface ...$values,
    ): DecimalNumInterface;

    public function diff(
        ?PositiveInt $scale,
        DecimalNumInterface $minuend,
        DecimalNumInterface ...$subtrahends,
    ): DecimalNumInterface;

    public function mod(
        DecimalNumInterface $dividend,
        DecimalNumInterface $divisor,
        ?PositiveInt $scale = null,
    ): DecimalNumInterface;

    public function compareTo(
        DecimalNumInterface $lhs,
        DecimalNumInterface $rhs,
        ?PositiveInt $scale = null,
    ): CmpResult;
}
