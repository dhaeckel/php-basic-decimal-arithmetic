<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

interface CalculatorInterface
{
    public function add(DecimalNum $augend, DecimalNum $addend): DecimalNum;

    public function sub(
        DecimalNum $minuend,
        DecimalNum $subtrahend,
    ): DecimalNum;

    public function mul(
        DecimalNum $multiplier,
        DecimalNum $multiplicand,
    ): DecimalNum;

    public function div(DecimalNum $dividend, DecimalNum $divisor): DecimalNum;

    public function sum(DecimalNum ...$values): DecimalNum;

    public function diff(
        DecimalNum $minuend,
        DecimalNum ...$subtrahends,
    ): DecimalNum;

    public function mod(
        DecimalNum $dividend,
        DecimalNum $divisor,
    ): DecimalNum;

    public function compareTo(DecimalNum $a, DecimalNum $b): CmpResult;
}
