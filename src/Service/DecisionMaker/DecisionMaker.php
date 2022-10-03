<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker;

use App\Entity\Flight;
use App\Service\DecisionMaker\Rule\RuleInterface;

class DecisionMaker implements DecisionMakerInterface
{
    private iterable $rules;

    public function __construct(iterable $rules)
    {
        $this->rules = $rules;
    }

    public function isClaimable(Flight $flight): DecisionResult
    {
        /** @var RuleInterface $rule */
        foreach ($this->rules as $rule) {
            if (false === $rule->isClaimable($flight)) {
                return new DecisionResult($flight, false);
            }
        }

        return new DecisionResult($flight, true);
    }
}