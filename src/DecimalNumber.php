<?php

declare(strict_types=1);

namespace Haeckel\Math;

class DecimalNumber implements \Stringable
{
    public readonly int $scale;

    /** @param string $value */
    public function __construct(public readonly string $value, ?int $scale = null)
    {
        if (\preg_match(' /^[+-]?[0-9]*(\.[0-9]*)?$/', $value) === 0) {
            throw new \InvalidArgumentException('Invalid numeric string: ' . $value);
        }
        if ($scale !== null) {
            $this->scale = $scale;
        } else {
            $dotPosition = \strpos($value, '.');
            if ($dotPosition === false) {
                $this->scale = 0;
            } else {
                $this->scale = \strlen($value) - $dotPosition - 1;
            }
        }
    }

    public static function fromInt(int $value): self
    {
        return new self((string) $value);
    }

    public static function fromFloat(float $value): self
    {
        return new self(\sprintf('%F', $value));
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
