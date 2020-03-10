<?php

namespace App\Domain;

final class Vehicle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $plateNumber;

    /**
     * @var Location
     */
    private $location;

    public function __construct(string $userId, string $plateNumber)
    {
        $this->userId = $userId;
        $this->plateNumber = $plateNumber;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function hasLocation()
    {
        return !is_null($this->location);
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
