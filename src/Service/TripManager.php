<?php
namespace App\Service;

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Trip;
use App\Repository\TripRepository;
use App\Repository\BikeRepository;
use App\Service\AppManager;
use Symfony\Component\HttpFoundation\Request;

class TripManager extends AppManager {

    private $tripRepository;
    private $bikeRepository;

    private $fromStation;
    private $toStation;
    private $user;
    private $bike;
    private $date;
    private $time;
    private $state = 'booked';

    public function __construct(
        EntityManagerInterface $entityManager,
        TripRepository $tripRepository,
        BikeRepository $bikeRepository){
        
        parent::__construct($entityManager);
        $this->tripRepository = $tripRepository;
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

        $this->entityManager->persist($trip);
        $this->entityManager->flush();

        return $trip;
    }

    public function setData(Request $request, User $user){
        $this->user = $user;
        $this->fromStation = $this->fetchStation($request->request->get('fromStation', ''));

        if(!$this->fromStation){
            return null;
        }

        $this->toStation = $this->fetchStation($request->request->get('toStation', ''));

        if(!$this->toStation){
            return null;
        }

        $this->bike = $this->fetchBike($request->request->get('bike', ''));

        if(!$this->bike){
            return null;
        }

        $this->date = \DateTime::createFromFormat('Y-m-d', $request->request->get('date', ''));
        $this->time = \DateTime::createFromFormat('H:i:s', $request->request->get('time', ''));

        return $this->persist();
    }

    private function fetchStation($id){
        return $this->tripRepository->find($id);
    }

    private function fetchBike($id){
        return $this->bikeRepository->find($id);
    }

}