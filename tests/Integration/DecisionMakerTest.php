<?php
declare(strict_types=1);

namespace App\Tests\Integration;

use App\Entity\Flight;
use App\Service\DecisionMaker\DecisionMaker;
use App\Service\DecisionMaker\DecisionMakerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DecisionMakerTest extends KernelTestCase
{
    public function dataForTestLogic()
    {
        return [
            ['LV', 'Cancel', 20, false],
            ['RU', 'Cancel', 10, false],
            ['LT', 'Delay', 1, false],
            ['LT', 'Delay', 3, true],
            ['LV', 'Delay', 4, true],
            ['LT', 'Cancel', 1, true],
        ];
    }

    /**
     * @dataProvider dataForTestLogic
     */
    public function testIsClaimable(string $countryCode, string $state, int $stateInfo, bool $result)
    {
        self::bootKernel();
        $container = static::getContainer();

        /** @var DecisionMaker $decisionMaker */
        $decisionMaker = $container->get(DecisionMakerInterface::class);
        $flight = new Flight();
        $flight->setDepartureCountryCode($countryCode);
        $flight->setState($state);
        $flight->setStateInfo($stateInfo);

        $this->assertEquals($decisionMaker->isClaimable($flight)->getResult(), $result);
    }
}