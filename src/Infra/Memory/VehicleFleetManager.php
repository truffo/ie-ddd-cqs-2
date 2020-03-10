<?php

namespace App\Infra\Memory;

use App\App\Command\CreateVehiculeCommand;
use App\App\Command\ParkVehiculeCommand;
use App\App\Command\RegisterVehiculeCommand;
use App\Domain\Vehicle;
use App\Domain\VehicleFleet;
use App\Domain\VehicleFleetManagerInterface;

final class VehicleFleetManager implements VehicleFleetManagerInterface
{
    public function createVehicle(CreateVehiculeCommand $createVehiculeCommand): Vehicle
    {
        $vehicule = new Vehicle($createVehiculeCommand->getUserId(), $createVehiculeCommand->getPlateNumber());
        VehicleFleetDataSet::$vehicles[$vehicule->getPlateNumber()] = $vehicule;

        return $vehicule;
    }

    public function register(RegisterVehiculeCommand $command)
    {
        $repo = new VehicleFleetRepository();
        /** @var VehicleFleet $fleet */
        $fleet = $repo->findByFleetId($command->getFleetId());

        if (is_null($fleet)) {
            throw new \LogicException('Invalid fleet id');
        }
        if ($fleet->contains($command->getPlateNumber())) {
            throw new \LogicException('Vehicle already registerd');
        }
        $fleet->addVehicle($command->getPlateNumber());
    }

    public function park(ParkVehiculeCommand $command)
    {
        $repo = new VehicleFleetRepository();

        $vehicule = $repo->findVehiculeByPlateNumber($command->getPlateNumber());

        if (is_null($vehicule)) {
            throw new \LogicException('Invalid vehicule id');
        }

        if ($vehicule->hasLocation()) {
            throw new \LogicException('Location already set');
        }
        $vehicule->setLocation($command->getLocation());
    }

    public function createFleet(string $fleetId, string $myUserId): VehicleFleet
    {
        VehicleFleetDataSet::$fleets[$fleetId] = new VehicleFleet($fleetId, $myUserId);

        return VehicleFleetDataSet::$fleets[$fleetId];
    }
}
