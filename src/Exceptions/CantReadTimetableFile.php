<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions;

use Exception;

final class CantReadTimetableFile extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromPath(string $path): CantReadTimetableFile
    {
        return new CantReadTimetableFile("Can not open Timetable file {$path}");
    }
}
