<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions;

use Exception;

final class CantReadSnapShotFile extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromPath(string $path): CantReadSnapShotFile
    {
        return new CantReadSnapShotFile("Can not open SnapShot file {$path}");
    }
}
