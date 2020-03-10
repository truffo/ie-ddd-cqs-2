<?php

use App\App\Command\CreateVehiculeCommand;
use App\App\Command\ParkVehiculeCommand;
use App\App\Command\RegisterVehiculeCommand;
use App\Domain\Vehicle;
use App\Domain\VehicleFleet;
use App\Domain\VehicleFleetRepositoryInterface;
use App\Infra\Memory\VehicleFleetManager;
use App\Infra\Memory\VehicleFleetRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use PHPUnit\Framework\Assert;

class DomainContext implements Context
{
    /**
     * @var string
     */
    private $myUserId;

    /**
     * @var VehicleFleetRepositoryInterface
     */
    private $fleetRepository;
    /**
     * @var VehicleFleet|null
     */
    private $myFleet;
    /**
     * @var VehicleFleetManager
     */
    private $fleetManager;
    /**
     * @var \App\Domain\Location
     */
    private $aLocation;
    /**
     * @var Vehicle
     */
    private $aVehicle;
    /**
     * @var bool
     */
    private $throwTryToRegisterThisVehicleIntoMyFleetException = false;

    /**
     * @var VehicleFleet
     */
    private $anotherFleet;
    /**
     * @var bool
     */
    private $throwTryToParkMyVehicleAtThisLocation = false;

    public function __construct()
    {
        $this->myUserId = 'user-id';
        $this->fleetRepository = new VehicleFleetRepository();
        $this->fleetManager = new VehicleFleetManager();

        $this->fleetManager->createFleet('fleet-1', $this->myUserId);
    }

    /** @BeforeScenario */
    public function before(BeforeScenarioScope $scope)
    {
        \App\Infra\Memory\VehicleFleetDataSet::$vehicles = [];
        \App\Infra\Memory\VehicleFleetDataSet::$fleets = [];
        $this->fleetManager->createFleet('fleet-1', $this->myUserId);
    }

    /** @AfterScenario */
    public function after(AfterScenarioScope $scope)
    {
    }

    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->myFleet = $this->fleetRepository->ofUser($this->myUserId);
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $command = new CreateVehiculeCommand($this->myUserId, 'AA-123-AA');
        $this->aVehicle = $this->fleetManager->createVehicle($command);
    }

    /**
     * @Given I have registered this vehicle into my fleet
     * @When I register this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $command = new RegisterVehiculeCommand($this->myFleet->getFleetId(), $this->aVehicle->getPlateNumber());
        $this->fleetManager->register($command);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->aLocation = new \App\Domain\Location(10.0, 15.0);
    }

    /**
     * @When I park my vehicle at this location
     * @Given my vehicle has been parked into this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $command = new ParkVehiculeCommand(
            $this->myFleet->getFleetId(),
            'AA-123-AA',
            $this->aLocation
        );
        $this->fleetManager->park($command);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        Assert::assertEquals(10.0, $this->aVehicle->getLocation()->getLatitude());
        Assert::assertEquals(15.0, $this->aVehicle->getLocation()->getLongitude());
        Assert::assertEquals($this->aLocation, $this->aVehicle->getLocation());
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try {
            $command = new ParkVehiculeCommand(
                $this->myFleet->getFleetId(),
                'AA-123-AA',
                $this->aLocation
            );
            $this->fleetManager->park($command);
        } catch (LogicException $e) {
            $this->throwTryToParkMyVehicleAtThisLocation = true;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        Assert::assertTrue($this->throwTryToParkMyVehicleAtThisLocation);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        /** @var VehicleFleet $fleet */
        $fleet = $this->fleetRepository->ofUser($this->myUserId);
        Assert::assertTrue($fleet->contains($this->aVehicle->getPlateNumber()));
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $command = new RegisterVehiculeCommand($this->myFleet->getFleetId(), $this->aVehicle->getPlateNumber());
            $this->fleetManager->register($command);
        } catch (LogicException $e) {
            $this->throwTryToRegisterThisVehicleIntoMyFleetException = true;
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        Assert::assertTrue($this->throwTryToRegisterThisVehicleIntoMyFleetException);
    }

    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->anotherFleet = $this->fleetManager->createFleet('fleet-2', 'another-user-1');
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $command = new RegisterVehiculeCommand($this->anotherFleet->getFleetId(), $this->aVehicle->getPlateNumber());
        $this->fleetManager->register($command);
    }
}
