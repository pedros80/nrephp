<?php

namespace Pedros80\NREphp\Darwin;

use Pedros80\NREphp\Darwin\Exceptions\InvalidFilterType;

final class FilterType
{
    private const VALID = [
        'from',
        'to',
    ];

    public function __construct(
        private string $filter
    ) {
        if (!in_array($filter, self::VALID)) {
            throw InvalidFilterType::fromFilter($filter);
        }
    }

    public function __toString(): string
    {
        return $this->filter;
    }
}
