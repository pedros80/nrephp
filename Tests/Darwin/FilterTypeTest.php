<?php

namespace Pedros80\NREphp\Tests\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidFilterType;
use Pedros80\NREphp\Darwin\FilterType;
use PHPUnit\Framework\TestCase;

final class FilterTypeTest extends TestCase
{
    public function testValidFilterTypeInstantiates(): void
    {
        $from = new FilterType('from');

        $this->assertInstanceOf(FilterType::class, $from);
        $this->assertEquals('from', (string) $from);

        $to = new FilterType('to');

        $this->assertInstanceOf(FilterType::class, $to);
        $this->assertEquals('to', (string) $to);
    }

    public function testInvalidFilterTypeThrowsException(): void
    {
        $this->expectException(InvalidFilterType::class);
        $this->expectExceptionMessage('INVALID is not a valid Filter Type.');

        new FilterType('INVALID');
    }
}
