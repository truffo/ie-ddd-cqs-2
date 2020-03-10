<?php

namespace App\App\Command;

use App\Domain\Location;

class ParkVehiculeCommand
{
    /**
     * @var string
     */
    private $fleetId;

    /**
     * @var string
     */
    private $plateNumber;

    /**
     * @var Location
     */
    private $location;

    public function __construct(string $fleetId, string $plateNumber, Location $location)
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
        $this->location = $location;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
