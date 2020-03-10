<?php

namespace App\Presentation\Command;

use App\Command\CreateVehiculeCommand;
use App\Domain\VehicleFleetManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FleetCreateCommand extends Command
{
    protected static $defaultName = 'fleet-create';

    /**
     * @var VehicleFleetManagerInterface
     */
    private $vehicleFleetManager;

    /**
     * FleetCreateCommand constructor.
     */
    public function __construct(string $name = null, VehicleFleetManagerInterface $vehicleFleetManager)
    {
        parent::__construct($name);
        $this->vehicleFleetManager = $vehicleFleetManager;
    }

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // $userId = $input->getArgument('user-id');
        $userId = '123soleil';
        $createVehiculeCommand = new CreateVehiculeCommand($userId);

        $this->vehicleFleetManager->createVehicle($createVehiculeCommand);

        return 0;
    }
}
