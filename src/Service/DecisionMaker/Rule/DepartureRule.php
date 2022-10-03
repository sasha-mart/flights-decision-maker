<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker\Rule;

use App\Entity\Flight;

class DepartureRule implements RuleInterface
{
    public function isClaimable(Flight $flight): bool
    {
        return $flight->isDepartureEU();
    }
}