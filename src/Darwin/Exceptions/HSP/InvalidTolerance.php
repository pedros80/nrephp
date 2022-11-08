<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions\HSP;

use Exception;

final class InvalidTolerance extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromLength(int $number): InvalidTolerance
    {
        return new InvalidTolerance("Invalid tolerance list length: {$number}; must be between 0 and 3");
    }

    public static function fromValue(mixed $value): InvalidTolerance
    {
        return new InvalidTolerance("Invalid tolerance list: {$value} is not an integer");
    }
}
