<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin;

final class ServiceID
{
    public function __construct(
        private string $id
    ) {
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
