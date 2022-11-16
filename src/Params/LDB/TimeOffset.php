<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\LDB;

use Pedros80\NREphp\Exceptions\InvalidTimeOffset;

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
