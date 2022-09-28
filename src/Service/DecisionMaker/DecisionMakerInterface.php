<?php
declare(strict_types=1);

namespace App\Service\DecisionMaker;

use App\Entity\Flight;

interface DecisionMakerInterface
{
    public function isClaimable(Flight $flight): DecisionResult;
}