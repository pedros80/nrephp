<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions;

use Exception;

final class InvalidNumRows extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromNumber(int $number, int $max): InvalidNumRows
    {
        return new InvalidNumRows("Invalid number of rows: {$number}; must be between 0 and {$max}");
    }
}
