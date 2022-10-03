<?php
declare(strict_types=1);

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DecideClaimableCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:decide-claimable');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'csv' => dirname(__FILE__) . '/test.csv',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(
            "LV Cancel 20 N\n" .
            "RU Cancel 10 N\n" .
            "LT Delay 1 N\n" .
            "LT Delay 3 Y\n" .
            "LV Delay 4 Y\n" .
            "LT Cancel 1 Y", $output);
    }
}