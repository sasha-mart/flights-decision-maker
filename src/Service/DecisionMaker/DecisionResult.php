<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker;

use App\Entity\Flight;

class DecisionResult
{
    private Flight $flight;
    private bool $result;

    public function __construct(Flight $flight, bool $result)
    {
        $this->flight = $flight;
        $this->result = $result;
    }

    public function getAsString(): string
    {
        return implode(' ', [
            $this->flight->getDepartureCountryCode(),
            $this->flight->getState(),
            $this->flight->getStateInfo(),
            $this->result ? 'Y' : 'N',
        ]);
    }

    /**
     * @return bool
     */
    public function getResult(): bool
    {
        return $this->result;
    }
}