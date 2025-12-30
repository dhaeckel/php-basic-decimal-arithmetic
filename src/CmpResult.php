<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic;

enum CmpResult
{
    case Equal;
    case GreaterThan;
    case LessThan;

    public static function fromInt(int $comparisonResult): self
    {
        return match (true) {
            $comparisonResult === 0 => self::Equal,
            $comparisonResult > 0 => self::GreaterThan,
            default => self::LessThan,
        };
    }
}
