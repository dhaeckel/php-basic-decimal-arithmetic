<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

use Haeckel\TypeWrapper\PositiveInt;

class DecimalNum implements \Stringable
{
    public readonly int $scale;

    /** @throws \InvalidArgumentException if scale is negative */
    public function __construct(public readonly string $value)
    {
        if (\preg_match(' /^[+-]?[0-9]*(\.[0-9]*)?$/', $value) === 0) {
            throw new \InvalidArgumentException(
                'Invalid numeric string: ' . $value,
            );
        }
        $dotPos = \strpos($value, '.');
        $this->scale = $dotPos === false ? 0 : \strlen($value) - $dotPos - 1;
    }

    public static function fromStringWithScale(
        string $value,
        PositiveInt $scale,
        int $roundMode = \PHP_ROUND_HALF_UP,
    ): self {
        $formattedValue = \sprintf(
            "%.{$scale}F",
            \round((float) $value, $scale->toInt(), $roundMode),
        );
        return new self($formattedValue, $scale);
    }

    public static function fromScientificNotationString(
        string $value,
        PositiveInt $scale,
        int $roundMode = \PHP_ROUND_HALF_UP,
    ): self {
        $value = \sprintf(
            "%.{$scale}F",
            \round((float) $value, $scale->toInt(), $roundMode),
        );
        return new self($value, $scale);
    }

    public static function fromFloat(
        float $value,
        PositiveInt $scale,
        int $roundMode = \PHP_ROUND_HALF_UP,
    ): self {
        return new self(
            \sprintf(
                "%.{$scale}F",
                \round($value, $scale->toInt(), $roundMode),
            ),
            $scale,
        );
    }

    public static function fromInt(int $value): self
    {
        return new self((string) $value, 0);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
