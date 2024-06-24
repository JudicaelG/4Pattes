<?php

namespace App\Controller;

use App\Entity\Ride;
use App\Form\RideType;
use App\Service\GetLatAndLongOfLocation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class RideController extends AbstractController
{
    #[Route('/ride', name: 'app_ride')]
    public function index(Request $request, EntityManagerInterface $entityManager, GetLatAndLongOfLocation $getLatAndLongOfLocation): Response
    {   
        $ride = new Ride();
        $form = $this->createForm(RideType::class, $ride);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $ride = $form->getData();
            $ride->setUserCreator($this->getUser());            
            $getLatAndLongOfLocation->GetLatAndLong($ride->getLocation());

            $ride->setLat($getLatAndLongOfLocation->getLat());
            $ride->SetLon($getLatAndLongOfLocation->GetLong());

            $entityManager->persist($ride);

            $entityManager->flush();
            
            $this->addFlash('success', 'La balade a bien été ajoutée');

            return $this->redirectToRoute('app_ride');
            
        }

        return $this->render('ride/index.html.twig', [
            'form' => $form
        ]);
    }
}
