<?php

namespace Pedros80\NREphp\Darwin\Exceptions;

use Exception;

final class InvalidFilterList extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromNumber(int $number, int $max): InvalidFilterList
    {
        return new InvalidFilterList("Invalid filter list length: {$number}; must be between 1 and {$max}");
    }
}
