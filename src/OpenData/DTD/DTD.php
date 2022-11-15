<?php

declare(strict_types=1);

namespace Pedros80\NREphp\OpenData\DTD;

use Pedros80\NREphp\OpenData\Services\Service;

final class DTD extends Service
{
    public function fares(string $token): string
    {
        return $this->call('2.0/fares', $token);
    }

    public function routeing(string $token): string
    {
        return $this->call('2.0/routeing', $token);
    }

    public function timetable(string $token): string
    {
        return $this->call('3.0/timetable', $token);
    }
}
