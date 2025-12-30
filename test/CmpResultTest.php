<?php

declare(strict_types=1);

namespace Haeckel\BasicDecimalArithmetic\Test;

use Haeckel\BasicDecimalArithmetic\CmpResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CmpResult::class)]
class CmpResultTest extends TestCase
{
    public function testFromIntEqual(): void
    {
        $result = CmpResult::fromInt(0);

        $this->assertEquals(CmpResult::Equal, $result);
    }

    public function testFromIntGreaterThan(): void
    {
        $result = CmpResult::fromInt(5);

        $this->assertEquals(CmpResult::GreaterThan, $result);
    }

    public function testFromIntLessThan(): void
    {
        $result = CmpResult::fromInt(-3);

        $this->assertEquals(CmpResult::LessThan, $result);
    }
}
