<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Params\HSP;

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
