<?php

namespace App\Infra\Doctrine;

use App\Domain\Vehicle;
use App\Domain\VehicleFleet;
use App\Domain\VehicleFleetRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class VehicleFleetRepository implements VehicleFleetRepositoryInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function ofUser(string $userId): ?VehicleFleet
    {
        return $this->em->getRepository(VehicleFleet::class)->findOneBy(['userId' => $userId]);
    }

    public function findByFleetId(string $fleetId): ?VehicleFleet
    {
        return $this->em->getRepository(VehicleFleet::class)->findOneBy(['fleetId' => $fleetId]);
    }

    public function findVehiculeByPlateNumber(string $plateNumber): ?Vehicle
    {
        return $this->em->getRepository(Vehicle::class)->findOneBy(['plateNumber' => $plateNumber]);
    }
}
