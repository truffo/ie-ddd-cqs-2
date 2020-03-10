<?php

namespace App\Domain;

class Location
{
    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var float
     */
    private $altitude;

    public function __construct(float $latitude, float $longitude, float $altitude = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->altitude = $altitude;
    }

    public static function fromString(string $locationAsString): self
    {
        list($latitude, $longitude) = sscanf($locationAsString, '%f,%f');

        return new self($latitude, $longitude);
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getAltitude(): float
    {
        return $this->altitude;
    }

    public function isEqualsTo(Location $location): bool
    {
        return
            $this->latitude === $location->latitude &&
            $this->longitude === $location->longitude &&
            $this->altitude === $location->altitude
        ;
    }
}
