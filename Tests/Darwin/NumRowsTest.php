<?php

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidNumRows;
use Pedros80\NREphp\Darwin\NumRows;
use PHPUnit\Framework\TestCase;

final class NumRowsTest extends TestCase
{
    public function testInstantiates(): void
    {
        $numRows = new NumRows(3, 10);

        $this->assertInstanceOf(NumRows::class, $numRows);
        $this->assertEquals(3, $numRows->value());
    }

    public function testLessThanZeroThrowsException(): void
    {
        $this->expectException(InvalidNumRows::class);
        $this->expectExceptionMessage('Invalid number of rows: -1; must be between 0 and 150');

        new NumRows(-1);
    }

    public function testGreaterThanMaxThrowsException(): void
    {
        $this->expectException(InvalidNumRows::class);
        $this->expectExceptionMessage('Invalid number of rows: 100; must be between 0 and 50');

        new NumRows(100, 50);
    }
}
