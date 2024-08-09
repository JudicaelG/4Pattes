<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Ride;
use App\Form\RideType;
use App\Form\SearchRideFormType;
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

        $ridesCreatedByTheUser = $entityManager->getRepository(Ride::class)->findRideCreatedByTheConnectedUser($this->getUser());
        $rides = $entityManager->getRepository(Ride::class)->findRidesWhereTheUserNotParticipate($this->getUser());
        $ridesWhereTheUserParticipate = $entityManager->getRepository(Ride::class)->findRideWhereTheUserParticipate($this->getUser());

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

        $formSearch = $this->createForm(SearchRideFormType::class);

        $formSearch->handleRequest($request);
        if($formSearch->isSubmitted() && $formSearch->isValid()){
            $getLatAndLongOfLocation->GetLatAndLong($formSearch->get('ville')->getData());

            $rides = $entityManager->getRepository(Ride::class)->findAllRideWithCertainDistance($getLatAndLongOfLocation->GetLat(), 
                $getLatAndLongOfLocation->GetLong(), $formSearch->get('distance')->getData(), $this->getUser()->getId());
        }

        return $this->render('ride/index.html.twig', [
            'form' => $form,
            'formSearch' => $formSearch,
            'ridesCreatedByTheUser' => $ridesCreatedByTheUser,
            'rides' => $rides,
            'ridesWhereTheUserParticipate' => $ridesWhereTheUserParticipate
        ]);
    }

    #[Route('/ride/participate/{id}', name: 'app_ride_participate')]
    public function participate(int $id, EntityManagerInterface $entityManager){
        $ride = $entityManager->getRepository(Ride::class)->find($id);


        if($ride){
            $participant = new Participant();
            $participant->addUserId($this->getUser());
            $participant->addRideId($ride);
            $entityManager->persist($participant);
    
            $ride->addParticipant($participant);
    
            $entityManager->flush();
    
            $this->addFlash('success', 'Vous participez à la balade');
            return $this->redirectToRoute('app_ride');
        }

        $this->addFlash('warning', 'La balade n\'existe pas');
        return $this->redirectToRoute('app_ride');
        
    }

    #[Route('/ride/not-participate/{id}', name: 'app_ride_not_participate')]
    public function notParticipate(int $id, EntityManagerInterface $entityManager){
        $ride = $entityManager->getRepository(Ride::class)->find($id);
        

        if($ride){
            $participant = $entityManager->getRepository(Participant::class)->findByUserIdAndRideId($this->getUser(), $ride->getId());

            if($participant){
                $ride->removeParticipant($participant);
    
                $entityManager->flush();
        
                $this->addFlash('success', 'Vous ne participez plus à la balade');
                return $this->redirectToRoute('app_ride');
            }

            $this->addFlash('warning', 'Une erreur c\'est produite');
        return $this->redirectToRoute('app_ride');
            
            
        }

        $this->addFlash('warning', 'La balade n\'existe pas');
        return $this->redirectToRoute('app_ride');
        
    }
}
