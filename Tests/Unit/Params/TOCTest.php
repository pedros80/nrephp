<?php

declare(strict_types=1);

namespace Tests\Unit\Params;

use Pedros80\NREphp\Exceptions\InvalidTOC;
use Pedros80\NREphp\Params\TOC;
use PHPUnit\Framework\TestCase;

final class TOCTest extends TestCase
{
    public function testValidTOCCanBeInstantiated(): void
    {
        $toc = new TOC('ZZ');

        $this->assertInstanceOf(TOC::class, $toc);
        $this->assertEquals('ZZ', (string) $toc);
    }

    public function testInvalidTOCThrowsException(): void
    {
        $this->expectException(InvalidTOC::class);
        $this->expectExceptionMessage('ZZZZZZZ is not a valid TOC.');

        new TOC('ZZZZZZZ');
    }
}
