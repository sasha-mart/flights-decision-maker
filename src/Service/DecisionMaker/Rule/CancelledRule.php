<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker\Rule;

use App\Entity\Flight;

class CancelledRule implements RuleInterface
{
    public function isClaimable(Flight $flight): bool
    {
        if ($flight->isCancelled() && $flight->getStateInfo() > 14) {
            return false;
        }

        return true;
    }
}