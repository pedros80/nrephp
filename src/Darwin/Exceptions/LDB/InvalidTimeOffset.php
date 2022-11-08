<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions\LDB;

use Exception;

final class InvalidTimeOffset extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromNumber(int $number): InvalidTimeOffset
    {
        return new InvalidTimeOffset("Invalid time offset: {$number}; must be between -120 and 120");
    }
}
