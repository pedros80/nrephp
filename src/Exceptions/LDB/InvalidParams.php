<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions\LDB;

use Exception;

final class InvalidParams extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromArray(array $params): InvalidParams
    {
        if (!count($params)) {
            return new InvalidParams('Invalid params: can not be empty.');
        } else {
            return new InvalidParams('Invalid params: must contain either board or service params.');
        }
    }
}
