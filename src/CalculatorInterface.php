<?php

declare(strict_types=1);

namespace Haeckel\Money;

use Haeckel\Math\CmpResult;
use Haeckel\Math\DecimalNumber;

interface CalculatorInterface
{
    public function add(DecimalNumber $augend, DecimalNumber $addend): DecimalNumber;
    public function sub(DecimalNumber $minuend, DecimalNumber $subtrahend): DecimalNumber;
    public function mul(DecimalNumber $multiplier, DecimalNumber $multiplicand): DecimalNumber;
    public function div(DecimalNumber $dividend, DecimalNumber $divisor): DecimalNumber;
    public function mod(DecimalNumber $dividend, DecimalNumber $divisor): DecimalNumber;
    public function pow(DecimalNumber $base, DecimalNumber $exponent): DecimalNumber;
    public function sum(DecimalNumber ...$values): DecimalNumber;
    public function diff(DecimalNumber $minuend, DecimalNumber ...$subtrahends): DecimalNumber;
    public function compareTo(DecimalNumber $a, DecimalNumber $b): CmpResult;
}
