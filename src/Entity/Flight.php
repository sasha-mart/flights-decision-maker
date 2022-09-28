<?php
declare(strict_types=1);

namespace App\Entity;

class Flight
{
    private string $departureCountryCode;
    private string $state;
    private int $stateInfo;

    public function getDepartureCountryCode(): string
    {
        return $this->departureCountryCode;
    }

    public function setDepartureCountryCode(string $departureCountryCode): void
    {
        $this->departureCountryCode = $departureCountryCode;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getStateInfo(): int
    {
        return $this->stateInfo;
    }

    public function setStateInfo(int $stateInfo): void
    {
        $this->stateInfo = $stateInfo;
    }

    public function isDepartureEU(): bool
    {
        return in_array($this->departureCountryCode, [
            'LV',
            'LT',
        ], true);
    }

    public function isCancelled(): bool
    {
        return $this->state === 'Cancel';
    }

    public function isDelayed(): bool
    {
        return $this->state === 'Delay';
    }
}