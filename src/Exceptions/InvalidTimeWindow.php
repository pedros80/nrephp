<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions;

use Exception;

final class InvalidTimeWindow extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromNumber(int $number): InvalidTimeWindow
    {
        return new InvalidTimeWindow("Invalid time window: {$number}; must be between -120 and 120");
    }
}
