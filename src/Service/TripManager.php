<?php
namespace App\Service;

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Trip;
use App\Repository\BikeRepository;
use App\Repository\StationRepository;
use App\Service\AppManager;
use Symfony\Component\HttpFoundation\Request;

class TripManager extends AppManager {

    private $stationRepository;
    private $bikeRepository;

    private $fromStation;
    private $toStation;
    private $user;
    private $bike;
    private $date;
    private $time;
    private $state = 'Booked';

    public function __construct(
        EntityManagerInterface $entityManager,
        StationRepository $stationRepository,
        BikeRepository $bikeRepository){
        
        parent::__construct($entityManager);
        $this->stationRepository = $stationRepository;
        $this->bikeRepository = $bikeRepository;
    }

    public function fetch(){
        
    }

    public function persist(){
        $trip = new Trip();
        $trip->setUser($this->user);
        $trip->setBike($this->bike);
        $trip->setState($this->state);
        $trip->setTripDate($this->date);
        $trip->setFromStationId($this->fromStation);
        $trip->setToStationId($this->toStation);
        $trip->setTripTime($this->time);

        $this->fromStation->setCurrentDockCount($this->fromStation->getCurrentDockCount() - 1);
        $this->toStation->setCurrentDockCount($this->toStation->getCurrentDockCount() + 1);
        
        $this->bike->setStation($this->toStation);
        $this->bike->setState($this->state);

        $this->entityManager->persist($trip);
        $this->entityManager->flush();

        return $trip;
    }

    public function setData($content, User $user){
        $this->user = $user;
        $this->fromStation = $this->fetchStation($content->{'fromStation'});
        
        if(!$this->fromStation){
            return null;
        }

        $this->toStation = $this->fetchStation($content->{'toStation'});

        if(!$this->toStation){
            return null;
        }

        $this->bike = $this->fetchBike($content->{'bike'});

        if(!$this->bike){
            return null;
        }

        $this->date = \DateTime::createFromFormat('Y-m-d', $content->{'date'});
        $this->time = \DateTime::createFromFormat('H:i:s', $content->{'time'});

        return $this->persist();
    }

    private function fetchStation($id){
        return $this->stationRepository->find($id);
    }

    private function fetchBike($id){
        return $this->bikeRepository->find($id);
    }

}