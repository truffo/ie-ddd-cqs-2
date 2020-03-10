<?php

namespace App\Domain;

use App\App\Command\CreateVehiculeCommand;
use App\App\Command\ParkVehiculeCommand;
use App\App\Command\RegisterVehiculeCommand;

interface VehicleFleetManagerInterface
{
    public function createVehicle(CreateVehiculeCommand $createVehiculeCommand): Vehicle;

    public function register(RegisterVehiculeCommand $command);

    public function park(ParkVehiculeCommand $command);
}
