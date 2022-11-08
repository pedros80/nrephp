<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Exceptions\HSP;

use Exception;
use Pedros80\NREphp\Darwin\Params\HSP\Days;

final class InvalidDays extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromDays(string $days): InvalidDays
    {
        return new InvalidDays("Invalid days: {$days}; must be one of " . implode(', ', Days::VALID));
    }
}
