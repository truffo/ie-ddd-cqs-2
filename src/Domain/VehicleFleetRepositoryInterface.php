<?php

namespace App\Domain;

interface VehicleFleetRepositoryInterface
{
    public function ofUser(string $userId): ?VehicleFleet;

    public function findByFleetId(string $fleetId): ?VehicleFleet;

    public function findVehiculeByPlateNumber(string $plateNumber): ?Vehicle;
}
