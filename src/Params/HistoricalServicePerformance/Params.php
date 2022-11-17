<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Params\HistoricalServicePerformance;

use Pedros80\NREphp\Exceptions\HistoricalServicePerformance\InvalidParams;
use Pedros80\NREphp\Params\HistoricalServicePerformance\Days;
use Pedros80\NREphp\Params\HistoricalServicePerformance\HistoricalDateTime;
use Pedros80\NREphp\Params\HistoricalServicePerformance\Rid;
use Pedros80\NREphp\Params\HistoricalServicePerformance\Tolerance;
use Pedros80\NREphp\Params\StationCode;
use Pedros80\NREphp\Params\TOC;

final class Params
{
    private function __construct(
        private ?StationCode $from_loc = null,
        private ?StationCode $to_loc = null,
        private ?HistoricalDateTime $from_date_time = null,
        private ?HistoricalDateTime $to_date_time = null,
        private ?Days $days = null,
        private ?Tolerance $tolerance = null,
        private ?TOC $toc = null,
        private ?Rid $rid = null
    ) {
    }

    public function toArray(): array
    {
        $out = [];

        if ($this->from_loc) {
            $out['from_loc'] = (string) $this->from_loc;
        }

        if ($this->to_loc) {
            $out['to_loc'] = (string) $this->to_loc;
        }

        if ($this->from_date_time) {
            $out['from_time'] = $this->from_date_time->time();
            $out['from_date'] = $this->from_date_time->date();
        }

        if ($this->to_date_time) {
            $out['to_time'] = $this->to_date_time->time();
            $out['to_date'] = $this->to_date_time->date();
        }

        if ($this->days) {
            $out['days'] = (string) $this->days;
        }

        if ($this->tolerance) {
            $out['tolerance'] = $this->tolerance->values();
        }

        if ($this->toc) {
            $out['toc'] = (string) $this->toc;
        }

        if ($this->rid) {
            $out['rid'] = (string) $this->rid;
        }

        return $out;
    }

    public static function fromArray(array $data): Params
    {
        if (!count($data) || (!isset($data['from_loc']) && !isset($data['rid']))) {
            throw InvalidParams::fromArray($data);
        }

        $from_loc       = isset($data['from_loc']) ? new StationCode($data['from_loc']) : null;
        $to_loc         = isset($data['to_loc']) ? new StationCode($data['to_loc']) : null;
        $from_date_time = isset($data['from_date_time']) ? HistoricalDateTime::fromString($data['from_date_time']) : null;
        $to_date_time   = isset($data['to_date_time']) ? HistoricalDateTime::fromString($data['to_date_time']) : null;
        $days           = isset($data['days']) ? new Days($data['days']) : null;
        $tolerance      = isset($data['tolerance']) ? new Tolerance($data['tolerance']) : null;
        $toc            = isset($data['toc']) ? new TOC($data['toc']) : null;
        $rid            = isset($data['rid']) ? new Rid($data['rid']) : null;

        return new Params($from_loc, $to_loc, $from_date_time, $to_date_time, $days, $tolerance, $toc, $rid);
    }
}
