<?php

declare(strict_types=1);

namespace Tests\Darwin\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Pedros80\NREphp\Darwin\Services\HSP;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class HSPTest extends TestCase
{
    use ProphecyTrait;

    public function testInvalidServiceMetricsReturnsSuccessFalse(): void
    {
        $client = $this->prophesize(Client::class);
        $hsp    = new HSP($client->reveal());

        $client->post('serviceMetrics', [
            'json' => [
                'from_loc'  => 'BTN',
                'to_loc'    => 'VIC',
                'from_time' => '0700',
                'from_date' => '2016-07-01',
                'to_time'   => '0800',
                'to_date'   => '2016-07-03',
                'days'      => 'WEEKDAY',
                'toc'       => 'GX',
            ]
        ])->willThrow(new ConnectException('connection problems. fml', new Request('post', 'serviceMetrics')));

        $result = $hsp->getServiceMetrics('BTN', 'VIC', '2016-07-01 07:00:00', '2016-07-03 08:00:00', 'WEEKDAY', 'GX');

        $this->assertIsObject($result);
        $this->assertFalse($result->success);
    }

    public function testGetServiceMetricsReturnsObject(): void
    {
        $client   = $this->prophesize(Client::class);
        $hsp      = new HSP($client->reveal());
        $response = '{"header":{"from_location":"BTN","to_location":"VIC"},"Services":[{"serviceAttributesMetrics":{"origin_location":"BTN","destination_location":"VIC","gbtt_ptd":"0712","gbtt_pta":"0823","toc_code":"GX","matched_services":"1","rids":["201607013361753"]},"Metrics":[{"tolerance_value":"0","num_not_tolerance":"0","num_tolerance":"1","percent_tolerance":"100","global_tolerance":true}]},{"serviceAttributesMetrics":{"origin_location":"BTN","destination_location":"VIC","gbtt_ptd":"0729","gbtt_pta":"0839","toc_code":"GX","matched_services":"1","rids":["201607013361763"]},"Metrics":[{"tolerance_value":"0","num_not_tolerance":"0","num_tolerance":"1","percent_tolerance":"100","global_tolerance":true}]},{"serviceAttributesMetrics":{"origin_location":"BTN","destination_location":"VIC","gbtt_ptd":"0744","gbtt_pta":"0855","toc_code":"GX","matched_services":"1","rids":["201607013361777"]},"Metrics":[{"tolerance_value":"0","num_not_tolerance":"0","num_tolerance":"1","percent_tolerance":"100","global_tolerance":true}]}]}';

        $client->post('serviceMetrics', [
            'json' => [
                'from_loc'  => 'BTN',
                'to_loc'    => 'VIC',
                'from_time' => '0700',
                'from_date' => '2016-07-01',
                'to_time'   => '0800',
                'to_date'   => '2016-07-03',
                'days'      => 'WEEKDAY',
                'toc'       => 'GX',
            ]
        ])->willReturn(new Response(200, [], $response));

        $result = $hsp->getServiceMetrics('BTN', 'VIC', '2016-07-01 07:00:00', '2016-07-03 08:00:00', 'WEEKDAY', 'GX');

        $this->assertIsObject($result);
    }

    public function testGetServiceDetailsReturnsObject(): void
    {
        $client   = $this->prophesize(Client::class);
        $response = '{"serviceAttributesDetails":{"date_of_service":"2016-07-01","toc_code":"GX","rid":"201607013361763","locations":[{"location":"BTN","gbtt_ptd":"0729","gbtt_pta":"","actual_td":"0729","actual_ta":"","late_canc_reason":""},{"location":"HSK","gbtt_ptd":"0738","gbtt_pta":"0737","actual_td":"","actual_ta":"0737","late_canc_reason":""},{"location":"HHE","gbtt_ptd":"0748","gbtt_pta":"0747","actual_td":"0750","actual_ta":"0748","late_canc_reason":""},{"location":"GTW","gbtt_ptd":"0802","gbtt_pta":"0800","actual_td":"0802","actual_ta":"0801","late_canc_reason":""},{"location":"VIC","gbtt_ptd":"","gbtt_pta":"0839","actual_td":"","actual_ta":"0836","late_canc_reason":""}]}}';

        $client->post('serviceDetails', [
            'json' => [
                'rid' => '201607013361763'
            ]
        ])->willReturn(new Response(200, [], $response));

        $hsp    = new HSP($client->reveal());
        $result = $hsp->getServiceDetails('201607013361763');

        $this->assertIsObject($result);
    }

    public function testInvalidServiceDetailsReturnsSuccessFalse(): void
    {
        $client = $this->prophesize(Client::class);

        $client->post('serviceDetails', [
            'json' => [
                'rid' => '201607013361763'
            ]
        ])->willThrow(new ConnectException('connection problems. fml', new Request('post', 'serviceMetrics')));

        $hsp    = new HSP($client->reveal());
        $result = $hsp->getServiceDetails('201607013361763');

        $this->assertIsObject($result);
        $this->assertFalse($result->success);
    }
}
