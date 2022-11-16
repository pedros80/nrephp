<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\LDB;

use Pedros80\NREphp\Exceptions\InvalidNumRows;

final class NumRows
{
    public const LONG  = 150;
    public const SHORT = 10;

    public function __construct(
        private int $value,
        private int $max = self::LONG
    ) {
        if ($value < 0 || $value > $max) {
            throw InvalidNumRows::fromNumber($value, $max);
        }
    }

    public function value(): int
    {
        return $this->value;
    }

    public function max(): int
    {
        return $this->max;
    }
}
