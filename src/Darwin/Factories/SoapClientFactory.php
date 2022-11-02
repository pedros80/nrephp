<?php

namespace Pedros80\NREphp\Darwin\Factories;

use SoapClient;
use SoapHeader;
use SoapVar;

final class SoapClientFactory
{
    private const VERSION = '2021-11-01';
    private const WSDL    = 'https://lite.realtime.nationalrail.co.uk/OpenLDBWS/wsdl.aspx?ver=';

    private const HEADER_NS   = 'http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes';
    private const HEADER_NAME = 'AccessToken';

    public function make(string $key, bool $trace = false): SoapClient
    {
        $opts = [
            'trace'        => $trace,
            'soap_version' => SOAP_1_2,
            'features'     => SOAP_SINGLE_ELEMENT_ARRAYS,
        ];

        if (extension_loaded('zlib')) {
            $opts['compression'] = SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP;
        }

        $client = new SoapClient(self::WSDL . self::VERSION, $opts);
        $token  = new SoapVar(['ns2:TokenValue' => $key], SOAP_ENC_OBJECT);
        $header = new SoapHeader(self::HEADER_NS, self::HEADER_NAME, $token);
        $client->__setSoapHeaders($header);

        return $client;
    }
}
