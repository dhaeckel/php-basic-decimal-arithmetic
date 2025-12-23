<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

enum LegacyRoundMode: int
{
    case HalfAwayFromZero = \PHP_ROUND_HALF_UP;
    case HalfTowardsZero = \PHP_ROUND_HALF_DOWN;
    case HalfToEven = \PHP_ROUND_HALF_EVEN;
    case HalfToOdd = \PHP_ROUND_HALF_ODD;
}
