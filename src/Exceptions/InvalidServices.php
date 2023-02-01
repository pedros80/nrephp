<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions;

use Exception;

final class InvalidServices extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $services): InvalidServices
    {
        return new InvalidServices("{$services} is not a valid Services choice.");
    }
}
