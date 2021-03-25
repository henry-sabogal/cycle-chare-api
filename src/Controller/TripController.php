<?php

namespace App\Controller;

use App\Service\UserManager;
use App\Service\TripManager;
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
        $user = $userManager->setData($request);
        $trip = $tripManager->setData($request, $user);
        
        if(!$trip){
            $data = array(
                'error' => "No trip was created",
                'id' => '',
                'email' => '',
                'success' => false
            );
        }else{
            $data = array(
                'error' => "",
                'id' => $trip->getId(),
                'email' => $trip->getUser()->getEmail(),
                'success' => true
            );
        }
        return $this->json($data);
    }
}
