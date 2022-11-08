<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions\HSP;

use Exception;

final class InvalidHistoricalDateTime extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromString(string $date_time): InvalidHistoricalDateTime
    {
        return new InvalidHistoricalDateTime("Invalid date time: {$date_time}");
    }
}
