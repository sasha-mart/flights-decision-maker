<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker\Rule;

use App\Entity\Flight;

class DelayRule implements RuleInterface
{
    public function isClaimable(Flight $flight): bool
    {
        if ($flight->isDelayed() && $flight->getStateInfo() < 3) {
            return false;
        }

        return true;
    }
}