<?php

namespace Pedros80\NREphp\Darwin\Services;

use Pedros80\NREphp\Shared\Services\Broker;

final class PushPortBroker extends Broker
{
    protected const HOST = 'darwin-dist-44ae45.nationalrail.co.uk';
    protected const PORT = 61613;

    protected const TOPICS = [
        'darwinpushport-v16',
        'darwin.status',
    ];

    public static function fromCredentials(string $user, string $pass): PushPortBroker
    {
        return new PushPortBroker(self::HOST, self::PORT, $user, $pass, self::TOPICS);
    }
}
