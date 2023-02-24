<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

use Stomp\Client;
use Stomp\Network\Connection;
use Stomp\Network\Observer\HeartbeatEmitter;
use Stomp\StatefulStomp;
use Stomp\Transport\Frame;

abstract class Broker
{
    private StatefulStomp $client;

    public function __construct(string $host, int $port, string $user, string $pass, array $topics)
    {
        $connection = new Connection("tcp://{$host}:{$port}");
        $client     = new Client($connection);
        $client->setLogin($user, $pass);
        $client->setClientId($user);
        // Once we've created the Stomp connection and client, we will add a heartbeat
        // to periodically let ActiveMQ know our connection is alive and healthy.
        $client->setHeartbeat(500);
        $connection->setReadTimeout(0, 250000);
        // We add a HeartBeatEmitter and attach it to the connection to automatically send these signals.
        $emitter = new HeartbeatEmitter($client->getConnection());
        $client->getConnection()->getObservers()->addObserver($emitter);
        // Lastly, we create our internal Stomp client which will be used in our methods to interact with ActiveMQ.
        $this->client = new StatefulStomp($client);
        $client->connect();

        foreach ($topics as $topic) {
            $subName = "{$user}-{$topic}";
            $this->client->subscribe("/topic/{$topic}", null, 'client-individual', ['activemq.subscriptionName' => $subName]);
        }
    }

    public function read(): ?Frame
    {
        return ($frame = $this->client->read()) ? $frame : null;
    }

    public function ack(Frame $message): void
    {
        $this->client->ack($message);
    }

    public function nack(Frame $message): void
    {
        $this->client->nack($message);
    }
}
