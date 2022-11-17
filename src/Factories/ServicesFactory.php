<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Factories;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use League\Flysystem\AwsS3V3\AwsS3V3Adapter;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use Pedros80\NREphp\Services\DTD;
use Pedros80\NREphp\Services\HistoricalServicePerformance;
use Pedros80\NREphp\Services\KnowledgeBase;
use Pedros80\NREphp\Services\LiveDepartureBoard;
use Pedros80\NREphp\Services\PushPortFiles;
use Pedros80\NREphp\Services\TimetableFiles;
use Pedros80\NREphp\Services\TokenGenerator;
use SoapClient;
use SoapHeader;
use SoapVar;

final class ServicesFactory
{
    private const WSDL_VERSION = '2021-11-01';
    private const WSDL         = 'https://lite.realtime.nationalrail.co.uk/OpenLDBWS/wsdl.aspx?ver=';

    private const HEADER_NS   = 'http://thalesgroup.com/RTTI/2010-11-01/ldb/commontypes';
    private const HEADER_NAME = 'AccessToken';

    private const FTP_HOST = 'darwin-dist-44ae45.nationalrail.co.uk';

    private const S3_BUCKET = 'darwin.xmltimetable';
    private const S3_PREFIX = 'PPTimetable/';

    private const HSP_URI    = 'https://hsp-prod.rockshore.net/api/v1/';

    private const AUTH_URI   = 'https://opendata.nationalrail.co.uk/authenticate';
    private const API_URI    = 'https://opendata.nationalrail.co.uk/api/staticfeeds/';

    private const USER_AGENT = 'NREphp';
    private const TIMEOUT    = 20;

    public function makeLiveDepartureBoard(string $key, bool $trace = false): LiveDepartureBoard
    {
        $opts = [
            'trace'        => $trace,
            'soap_version' => SOAP_1_2,
            'features'     => SOAP_SINGLE_ELEMENT_ARRAYS,
        ];

        if (extension_loaded('zlib')) {
            $opts['compression'] = SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP;
        }

        $client = new SoapClient(self::WSDL . self::WSDL_VERSION, $opts);
        $header = new SoapHeader(
            self::HEADER_NS,
            self::HEADER_NAME,
            new SoapVar(['ns2:TokenValue' => $key], SOAP_ENC_OBJECT)
        );
        $client->__setSoapHeaders($header);

        return new LiveDepartureBoard($client);
    }

    public function makeHistoricalServicePerformance(string $user, string $pass): HistoricalServicePerformance
    {
        $auth = base64_encode("{$user}:{$pass}");

        return new HistoricalServicePerformance(
            new Client([
                'base_uri'               => self::HSP_URI,
                RequestOptions::HEADERS  => [
                    'User-Agent'    => self::USER_AGENT,
                    'Authorization' => "Basic {$auth}",
                    'Content-Type'  => 'application/json',
                ],
                RequestOptions::TIMEOUT => self::TIMEOUT,
            ])
        );
    }

    public function makePushPortFiles(string $user, string $pass): PushPortFiles
    {
        return new PushPortFiles(
            new Filesystem(
                new FtpAdapter(
                    FtpConnectionOptions::fromArray([
                        'host'     => self::FTP_HOST,
                        'root'     => '',
                        'username' => $user,
                        'password' => $pass,
                    ])
                )
            )
        );
    }

    public function makeTimetableFiles(string $key, string $secret): TimetableFiles
    {
        return new TimetableFiles(
            new Filesystem(
                new AwsS3V3Adapter(
                    new S3Client([
                        'version'     => 'latest',
                        'region'      => 'eu-west-1',
                        'credentials' => new Credentials($key, $secret),
                    ]),
                    self::S3_BUCKET,
                    self::S3_PREFIX
                )
            )
        );
    }

    public function makeDTD(): DTD
    {
        return new DTD($this->makeClient());
    }

    public function makeKnowledgeBase(): KnowledgeBase
    {
        return new KnowledgeBase($this->makeClient());
    }

    public function makeTokenGenerator(string $user, string $pass): TokenGenerator
    {
        return new TokenGenerator(
            new Client([
                'base_uri'               => self::AUTH_URI,
                RequestOptions::HEADERS  => [
                    'User-Agent'   => self::USER_AGENT,
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                RequestOptions::TIMEOUT => self::TIMEOUT,
            ]),
            $user,
            $pass
        );
    }

    private function makeClient(): Client
    {
        return new Client([
            'base_uri'              => self::API_URI,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
            ],
            RequestOptions::TIMEOUT => self::TIMEOUT,
        ]);
    }
}
