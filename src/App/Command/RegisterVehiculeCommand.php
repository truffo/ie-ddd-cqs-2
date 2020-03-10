<?php

namespace App\App\Command;

class RegisterVehiculeCommand
{
    /**
     * @var string
     */
    private $fleetId;

    /**
     * @var string
     */
    private $plateNumber;

    public function __construct(string $fleetId, string $plateNumber)
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }
}
