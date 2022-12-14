<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\HistoricalServicePerformance;

use Pedros80\NREphp\Exceptions\InvalidDays;

final class Days
{
    public const WEEKDAY  = 'WEEKDAY';
    public const SATURDAY = 'SATURDAY';
    public const SUNDAY   = 'SUNDAY';

    public const VALID = [
        self::WEEKDAY,
        self::SATURDAY,
        self::SUNDAY,
    ];

    public function __construct(private string $days)
    {
        if (!in_array(strtoupper($days), self::VALID)) {
            throw InvalidDays::fromDays($days);
        }
    }

    public function __toString(): string
    {
        return strtoupper($this->days);
    }
}
