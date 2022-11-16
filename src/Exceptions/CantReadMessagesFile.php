<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions;

use Exception;

final class CantReadMessagesFile extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromPath(string $path): CantReadMessagesFile
    {
        return new CantReadMessagesFile("Can not open Messages file {$path}");
    }
}
