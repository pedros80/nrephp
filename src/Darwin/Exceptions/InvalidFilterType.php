<?php

namespace Pedros80\NREphp\Darwin\Exceptions;

use Exception;

final class InvalidFilterType extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromFilter(string $filter): InvalidFilterType
    {
        return new InvalidFilterType("{$filter} is not a valid Filter Type.");
    }
}
