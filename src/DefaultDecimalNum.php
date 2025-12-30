<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic;

use Haeckel\TypeWrapper\NonNegativeInt;

class DefaultDecimalNum implements DecimalNumInterface
{
    /**
     * @param numeric-string&non-empty-string $value
     * narrower than numeric-string, scientific notation is disallowed
     *
     * @throws \ValueError
     * if value is empty, not numeric or in scientific notation
     */
    public function __construct(private readonly string $value)
    {
        if ($value === '') {
            throw new \ValueError('Value cannot be an empty string');
        }

        if (! \is_numeric($value)) {
            throw new \ValueError(
                'Value must be a numeric string: ' . $value,
            );
        }

        if (\str_contains($value, 'e') || \str_contains($value, 'E')) {
            throw new \ValueError(
                'Value cannot be in scientific notation, '
                . 'use fromScientificNotationString. '
                . "Given value: $value"
            );
        }
    }

    public static function fromStringWithScale(
        string $value,
        NonNegativeInt $scale,
        LegacyRoundMode $roundMode = LegacyRoundMode::HalfAwayFromZero,
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
        NonNegativeInt $scale,
        LegacyRoundMode $roundMode = LegacyRoundMode::HalfAwayFromZero,
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
        NonNegativeInt $scale,
        LegacyRoundMode $roundMode = LegacyRoundMode::HalfAwayFromZero,
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
