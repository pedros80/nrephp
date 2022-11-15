<?php

namespace Pedros80\NREphp\OpenData\KnowledgeBase;

use Pedros80\NREphp\Shared\Services\Broker;

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
