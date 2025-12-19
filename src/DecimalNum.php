<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

use Haeckel\TypeWrapper\PositiveInt;

class DecimalNum implements DecimalNumInterface
{
    /**
     * @param numeric-string $value narrower than numeric-string,
     * scientific notation is disallowed
     * @throws \InvalidArgumentException if value does not pass regex validation
     */
    public function __construct(private readonly string $value)
    {
        if (\preg_match(' /^[+-]?[0-9]*(\.[0-9]*)?$/', $value) === 0) {
            throw new \InvalidArgumentException(
                'Invalid numeric string: ' . $value,
            );
        }
    }

    public static function fromStringWithScale(
        string $value,
        PositiveInt $scale,
        LegacyRoundingMode $roundMode = LegacyRoundingMode::HalfAwayFromZero,
    ): self {
        /** @var numeric-string $formattedValue */
        $formattedValue = \sprintf(
            "%.{$scale}F",
            \round((float) $value, $scale->toInt(), $roundMode->value),
        );
        return new self($formattedValue);
    }

    public static function fromScientificNotationString(
        string $value,
        PositiveInt $scale,
        LegacyRoundingMode $roundMode = LegacyRoundingMode::HalfAwayFromZero,
    ): self {
        /** @var numeric-string $value */
        $value = \sprintf(
            "%.{$scale}F",
            \round((float) $value, $scale->toInt(), $roundMode->value),
        );
        return new self($value);
    }

    public static function fromFloat(
        float $value,
        PositiveInt $scale,
        LegacyRoundingMode $roundMode = LegacyRoundingMode::HalfAwayFromZero,
    ): self {
        /** @var numeric-string $val */
        $val = \sprintf(
            "%.{$scale}F",
            \round($value, $scale->toInt(), $roundMode->value),
        );
        return new self($val);
    }

    public static function fromInt(int $value): self
    {
        return new self((string) $value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /** @return numeric-string */
    public function val(): string
    {
        return $this->value;
    }
}
