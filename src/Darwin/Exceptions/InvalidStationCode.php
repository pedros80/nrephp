<?php

namespace Pedros80\NREphp\Darwin\Exceptions;

use Exception;

final class InvalidStationCode extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromCode(string $code): InvalidStationCode
    {
        return new InvalidStationCode("{$code} is not a valid Station Code.");
    }
}
