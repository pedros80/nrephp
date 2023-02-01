<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\LiveDepartureBoard;

use Pedros80\NREphp\Exceptions\InvalidServices;

final class Services
{
    public function __construct(
        private string $services
    ) {
        if (!in_array($services, ['P', 'B', 'S'])) {
            throw InvalidServices::fromString($services);
        }
    }

    public function __toString(): string
    {
        return $this->services;
    }
}
