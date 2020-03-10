<?php

namespace App\Domain;

final class VehicleFleet
{
    private $vehicles = [];
    private $fleetId;

    private $userId;

    public function __construct(string $fleetId, string $userId)
    {
        $this->userId = $userId;
        $this->fleetId = $fleetId;
        $this->vehicles = [];
    }

    public function hasUserId($userId): bool
    {
        return $this->userId == $userId;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function addVehicle(string $plateNumber)
    {
        $this->vehicles[$plateNumber] = $plateNumber;
    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function contains(string $plateNumber): bool
    {
        return array_key_exists($plateNumber, $this->vehicles);
    }
}
