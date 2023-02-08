<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use Pedros80\NREphp\Services\Broker;

final class PushPortBroker extends Broker
{
    protected const HOST = 'darwin-dist-44ae45.nationalrail.co.uk';
    protected const PORT = 61613;

    protected const TOPICS = [
        'darwin.pushport-v16',
        'darwin.status',
    ];

    public static function fromCredentials(string $user, string $pass): PushPortBroker
    {
        return new PushPortBroker(self::HOST, self::PORT, $user, $pass, self::TOPICS);
    }
}
