<?php

namespace App\Infra\Doctrine;

use App\App\Command\CreateVehiculeCommand;
use App\App\Command\ParkVehiculeCommand;
use App\App\Command\RegisterVehiculeCommand;
use App\Domain\Vehicle;
use App\Domain\VehicleFleetManagerInterface;
use App\Domain\VehicleFleetRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class VehicleFleetManager implements VehicleFleetManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var VehicleFleetRepositoryInterface
     */
    private $vehicleFleetRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->vehicleFleetRepository = new VehicleFleetRepository($this->em);
    }

    public function createVehicle(CreateVehiculeCommand $createVehiculeCommand): Vehicle
    {
        $userId = $createVehiculeCommand->getUserId();
        $vehicle = new Vehicle($userId);
        $this->em->persist($vehicle);
        $this->em->flush();

        return $vehicle;
    }

    public function register(RegisterVehiculeCommand $command)
    {
        $aFleet = $this->vehicleFleetRepository->findByFleetId($command->getFleetId());
        if (null === $aFleet) {
            throw new \LogicException('Invalid value for fleet');
        }

        $aVehicle = $this->vehicleFleetRepository->findVehiculeByPlateNumber($command->getPlateNumber());
        if (null === $aVehicle) {
            throw new \LogicException('Invalid value for plate number');
        }

        // TODO: implements
    }

    public function park(ParkVehiculeCommand $command)
    {
        $aVehicle = $this->vehicleFleetRepository->findVehiculeByPlateNumber($command->getPlateNumber());
        if (null === $aVehicle) {
            throw new \LogicException('Invalid value for plate number');
        }
        // TODO: implements
    }
}
