<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\HistoricalServicePerformance;

use DateTimeImmutable;
use Pedros80\NREphp\Exceptions\InvalidHistoricalDateTime;

final class HistoricalDateTime
{
    private function __construct(
        private DateTimeImmutable $dateTime
    ) {
    }

    public function date(): string
    {
        return $this->dateTime->format('Y-m-d');
    }

    public function time(): string
    {
        return $this->dateTime->format('Hi');
    }

    public static function fromString(string $dateTime): HistoricalDateTime
    {
        $dti = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $dateTime);

        $now = new DateTimeImmutable();

        if ($dti === false || $dti >= $now) {
            throw InvalidHistoricalDateTime::fromString($dateTime);
        }

        return new HistoricalDateTime($dti);
    }
}
