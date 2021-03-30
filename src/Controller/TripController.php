<?php

namespace App\Controller;

use App\Service\UserManager;
use App\Service\TripManager;
use App\Repository\TripRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trip")
 */
class TripController extends AbstractController
{
    /**
     * @Route("/", name="trip_index", methods={"POST"})
     */
    public function index(Request $request, UserManager $userManager, TripManager $tripManager): Response
    {
        $data;
        $content = json_decode($request->getContent());
        $user = $userManager->setData($content);
        $trip = $tripManager->setData($content, $user);
        
        if(!$trip){
            $data = array(
                'error' => "No trip was created",
                'id' => "NULL",
                'email' => "NULL",
                'success' => false
            );
        }else{
            $data = array(
                'error' => "NULL",
                'id' => $trip->getId(),
                'email' => $trip->getUser()->getEmail(),
                'success' => true
            );
        }
            
        return $this->json($data);
    }

    /**
     * @Route("/user/{id_gmail}", name="trips_user", methods={"GET"})
     */
    public function userTrips(TripRepository $tripRepository, UserRepository $userRepository, $id_gmail): Response {
        
        $user = $userRepository->findByIdGmail($id_gmail);
        $trips = $tripRepository->findByUser($user);

        return $this->json($trips);   
    }
}
