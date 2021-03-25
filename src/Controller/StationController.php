<?php

namespace App\Controller;

use App\Entity\Station;
use App\Entity\Bike;
use App\Form\StationType;
use App\Repository\StationRepository;
use App\Repository\BikeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/station")
 */
class StationController extends AbstractController
{
    /**
     * @Route("/", name="station_index", methods={"GET"})
     */
    public function index(StationRepository $stationRepository): Response
    {
        return $this->json($stationRepository->findAllForJson());
    }

    /**
     * @Route("/{id}", name="station_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $station = $this->getDoctrine()
            ->getRepository(Station::class)
            ->findOneById($id);

        $bikes = $this->getDoctrine()
            ->getRepository(Bike::class)
            ->findByStation($station);

        $data = array(
            'id' => $station->getId(),
            'name' => $station->getName(),
            'lon' => $station->getLon(),
            'lat' => $station->getLat(),
            'current_dockCount' => $station->getCurrentDockCount(),
            'bikes' => $bikes
        );

        return $this->json($data);
    }
}
