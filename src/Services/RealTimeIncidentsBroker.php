<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use Pedros80\NREphp\Services\Broker;

final class RealTimeIncidentsBroker extends Broker
{
    private const HOST = 'kb-dist-261e4f.nationalrail.co.uk';
    private const PORT = 61613;

    private const TOPICS = [
        'kb.incidents',
    ];

    public static function fromCredentials(string $user, string $pass): RealTimeIncidentsBroker
    {
        return new RealTimeIncidentsBroker(self::HOST, self::PORT, $user, $pass, self::TOPICS);
    }
}
