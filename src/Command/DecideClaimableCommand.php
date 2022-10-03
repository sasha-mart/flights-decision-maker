<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Flight;
use App\Service\DecisionMaker\DecisionMakerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:decide-claimable')]
class DecideClaimableCommand extends Command
{
    private DecisionMakerInterface $decisionMaker;

    public function __construct(DecisionMakerInterface $decisionMaker)
    {
        $this->decisionMaker = $decisionMaker;
        parent::__construct();
    }

    protected function configure()
    {
        $this->addArgument('csv', InputArgument::REQUIRED, 'CSV file with list of flights.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('csv');
        $handle = fopen($filePath, 'r');

        if (false === $handle) {
            return Command::INVALID;
        }

        /** @var Flight $flight */
        foreach ($this->parseCsvToFlights($handle) as $flight) {
            $output->writeln($this->decisionMaker->isClaimable($flight)->getAsString());
        }

        return Command::SUCCESS;
    }

    private function parseCsvToFlights($handle): \Generator
    {
        for (;;) {
            $data = fgetcsv($handle, 100);
            if ($data === false) {
                break;
            }

            // TODO validation of flights
            $flight = new Flight();
            $flight->setDepartureCountryCode(trim($data[0]));
            $flight->setState(trim($data[1]));
            $flight->setStateInfo((int)$data[2]);

            yield $flight;
        }
        fclose($handle);
    }
}