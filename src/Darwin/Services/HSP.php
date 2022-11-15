<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Darwin\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Pedros80\NREphp\Darwin\Params\HSP\Params;
use stdClass;

final class HSP
{
    public function __construct(
        private Client $client
    ) {
    }

    public function getServiceMetrics(
        string $from_loc,
        string $to_loc,
        string $from_date_time,
        string $to_date_time,
        string $days,
        ?string $toc = null,
        ?array $tolerance = null
    ): stdClass {
        $params = Params::fromArray([
            'from_loc'       => $from_loc,
            'to_loc'         => $to_loc,
            'from_date_time' => $from_date_time,
            'to_date_time'   => $to_date_time,
            'days'           => $days,
            'toc'            => $toc,
            'tolerance'      => $tolerance,
        ]);

        try {
            return $this->call('serviceMetrics', $params);
        } catch (ConnectException) {
            return (object) ['success' => false];
        }
    }

    public function getServiceDetails(string $rid): stdClass
    {
        $params = Params::fromArray([
            'rid' => $rid,
        ]);

        try {
            return $this->call('serviceDetails', $params);
        } catch (ConnectException) {
            return (object) ['success' => false];
        }
    }

    private function call(string $endpoint, Params $params): stdClass
    {
        $response = $this->client->post($endpoint, [
            'json' => $params->toArray(),
        ]);

        return json_decode((string) $response->getBody());
    }
}
