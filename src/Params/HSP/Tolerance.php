<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\HSP;

use Pedros80\NREphp\Exceptions\InvalidTolerance;

final class Tolerance
{
    public function __construct(
        private array $values
    ) {
        if (count($values) > 3) {
            throw InvalidTolerance::fromLength(count($values));
        }

        foreach ($values as $value) {
            if (!is_int($value)) {
                throw InvalidTolerance::fromValue($value);
            }
        }
    }

    public function values(): array
    {
        return $this->values;
    }
}
