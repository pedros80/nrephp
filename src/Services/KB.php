<?php

declare(strict_types=1);

namespace Pedros80\NREphp\Services;

final class KB extends Service
{
    public function serviceIndicators(string $token): string
    {
        return $this->call('4.0/serviceIndicators', $token);
    }

    public function incidents(string $token): string
    {
        return $this->call('5.0/incidents', $token);
    }

    public function tocs(string $token): string
    {
        return $this->call('4.0/tocs', $token);
    }

    public function ticketRestrictions(string $token): string
    {
        return $this->call('4.0/ticket-restrictions', $token);
    }

    public function ticketTypes(string $token): string
    {
        return $this->call('4.0/ticket-types', $token);
    }

    public function publicPromotions(string $token): string
    {
        return $this->call('4.0/promotions-publics', $token);
    }

    public function stations(string $token): string
    {
        return $this->call('4.0/stations', $token);
    }
}
