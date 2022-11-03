<?php

namespace Tests\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidFilterList;
use Pedros80\NREphp\Darwin\Exceptions\InvalidStationCode;
use Pedros80\NREphp\Darwin\FilterList;
use PHPUnit\Framework\TestCase;

final class FilterListTest extends TestCase
{
    public function testValidFilterListInstantiates(): void
    {
        $filterList = new FilterList(['DAM', 'KDY', 'DEE'], 5);
        $this->assertInstanceOf(FilterList::class, $filterList);
        $this->assertEquals(['DAM', 'KDY', 'DEE'], $filterList->value());
    }

    public function testEmptyFilterListThrowsException(): void
    {
        $this->expectException(InvalidFilterList::class);
        $this->expectExceptionMessage('Invalid filter list length: 0; must be between 1 and 5');

        new FilterList([], 5);
    }

    public function testTooLongFilterListThrowsException(): void
    {
        $this->expectException(InvalidFilterList::class);
        $this->expectExceptionMessage('Invalid filter list length: 3; must be between 1 and 2');

        new FilterList(['DAM', 'KDY', 'DEE'], 2);
    }

    public function testInvalidStationThrowsException(): void
    {
        $this->expectException(InvalidStationCode::class);
        $this->expectExceptionMessage('XXX is not a valid Station Code.');

        new FilterList(['DAM', 'XXX'], 2);
    }
}
