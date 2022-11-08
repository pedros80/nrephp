<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Params\HSP;

use DateTimeImmutable;
use Pedros80\NREphp\Darwin\Exceptions\HSP\InvalidHistoricalDateTime;

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
