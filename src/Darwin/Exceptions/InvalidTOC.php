<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions;

use Exception;

final class InvalidTOC extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromCode(string $code): InvalidTOC
    {
        return new InvalidTOC("{$code} is not a valid TOC.");
    }
}
