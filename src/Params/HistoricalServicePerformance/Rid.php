<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\HistoricalServicePerformance;

final class Rid
{
    public function __construct(
        private string $rid
    ) {
        // @todo - validate $rid
    }

    public function __toString(): string
    {
        return $this->rid;
    }
}
