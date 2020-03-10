<?php

namespace App\Infra\Memory;

use App\Domain\Vehicle;
use App\Domain\VehicleFleet;
use App\Domain\VehicleFleetRepositoryInterface;

final class VehicleFleetRepository implements VehicleFleetRepositoryInterface
{
    public function ofUser(string $userId): ?VehicleFleet
    {
        foreach (VehicleFleetDataSet::$fleets as $fleet) {
            if ($fleet->hasUserId($userId)) {
                return $fleet;
            }
        }

        return null;
    }

    public function findByFleetId(string $fleetId): ?VehicleFleet
    {
        foreach (VehicleFleetDataSet::$fleets as $fleet) {
            if ($fleet->getFleetId() == $fleetId) {
                return $fleet;
            }
        }

        return null;
    }

    public function findVehiculeByPlateNumber(string $plateNumber): ?Vehicle
    {
        return VehicleFleetDataSet::$vehicles[$plateNumber];
    }
}
