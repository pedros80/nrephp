<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Params\LDB;

use Pedros80\NREphp\Darwin\Exceptions\LDB\InvalidTimeWindow;

final class TimeWindow
{
    public const MIN = -120;
    public const MAX = 120;

    public function __construct(
        private int $offset
    ) {
        if ($offset < self::MIN || $offset > self::MAX) {
            throw InvalidTimeWindow::fromNumber($offset);
        }
    }

    public function value(): int
    {
        return $this->offset;
    }

    public function __toString(): string
    {
        return (string) $this->offset;
    }
}