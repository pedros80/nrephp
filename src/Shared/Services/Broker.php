<?php

namespace Pedros80\NREphp\Shared\Services;

use Stomp\Client;
use Stomp\Network\Connection;
use Stomp\Network\Observer\HeartbeatEmitter;
use Stomp\StatefulStomp;
use Stomp\Transport\Frame;

final class Broker
{
    private StatefulStomp $client;

    private array $subscriptions = [];

    public function __construct(string $host, int $port, string $user, string $pass)
    {
        $connection = new Connection('tcp://' . $host . ':' . $port);
        $client     = new Client($connection);
        $client->setLogin($user, $pass);
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
    }

    public function subscribe(string $topic, ?string $selector = null): void
    {
        $destination                       = '/topic/' . $topic;
        $this->subscriptions[$destination] = $this->client->subscribe($destination, $selector, 'client-individual');
    }

    public function unsubscribe(?string $topic = null): void
    {
        if ($topic) {
            $destination = '/topic/' . $topic;
            if (isset($this->subscriptions[$destination])) {
                $this->client->unsubscribe($this->subscriptions[$destination]);
            }
        } else {
            $this->client->unsubscribe();
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
