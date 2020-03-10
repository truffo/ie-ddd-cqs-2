<?php

namespace App\App\Command;

class CreateVehiculeCommand
{
    private $userId;
    /**
     * @var string
     */
    private $plateNumber;

    public function __construct(string $userId, string $plateNumber)
    {
        $this->userId = $userId;
        $this->plateNumber = $plateNumber;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPlateNumber()
    {
        return $this->plateNumber;
    }
}
