<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Exceptions\LiveDepartureBoard;

use DOMDocument;
use Exception;

final class LiveDepartureBoardException extends Exception
{
    private function __construct(string $message)
    {
        parent::__construct($message, 400);
    }

    public static function fromResponse(string $message, ?string $request, ?string $response): LiveDepartureBoardException
    {
        if ($request) {
            $xml = new DOMDocument();
            $xml->loadXML($request);
            $token = $xml->getElementsByTagNameNS('http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes', 'TokenValue')->item(0);
            if ($token) {
                $token->nodeValue = '[REDACTED]';
            }
            $xml->preserveWhiteSpace = false;
            $xml->formatOutput       = true;
            $request                 = $xml->saveXML();
        }

        if ($response) {
            $xml = new DOMDocument();
            $xml->loadXML($response);
            $xml->preserveWhiteSpace = false;
            $xml->formatOutput       = true;
            $response                = $xml->saveXML();
        }

        return new LiveDepartureBoardException(implode("\n\n", array_filter([$message, $request, $response])));
    }
}
