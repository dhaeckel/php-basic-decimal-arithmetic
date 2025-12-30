<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic;

interface DecimalNumInterface extends \Stringable
{
    /** @return numeric-string&non-empty-string */
    public function val(): string;
}
