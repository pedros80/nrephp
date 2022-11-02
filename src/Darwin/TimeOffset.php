<?php

namespace Pedros80\NREphp\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidTimeOffset;

final class TimeOffset
{
    public const MIN = -120;
    public const MAX = 120;

    public function __construct(
        private int $offset
    ) {
        if ($offset < self::MIN || $offset > self::MAX) {
            throw InvalidTimeOffset::fromNumber($offset);
        }
    }

    public function value(): int
    {
        return $this->offset;
    }
}
