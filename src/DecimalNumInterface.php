<?php

declare(strict_types=1);

namespace Haeckel\BasicDecArithm;

interface DecimalNumInterface extends \Stringable
{
    /** @return numeric-string */
    public function val(): string;
}
