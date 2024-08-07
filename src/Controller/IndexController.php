<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals;
use App\Entity\Ride;
use App\Form\SearchRideFormType;
use App\Mapper\AnimalMapper;
use App\Service\GetLatAndLongOfLocation;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager, AnimalMapper $animalMapper, Request $request, GetLatAndLongOfLocation $getLatAndLongOfLocation):Response{

        $animalsOfTheUser = $animalMapper->map($entityManager->getRepository(Animals::class)
        ->getConnectedUserAnimals($this->getUser()));
        $rides = $entityManager->getRepository(Ride::class)->findRidesWhereTheUserNotParticipate($this->getUser());
        //$ridesWithDistance = $entityManager->getRepository(Ride::class)->findAllRideWithCertainDistance(48.862725, 2.287592, 300);
        $form = $this->createForm(SearchRideFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $getLatAndLongOfLocation->GetLatAndLong($form->get('ville')->getData());

            $rides = $entityManager->getRepository(Ride::class)->findAllRideWithCertainDistance($getLatAndLongOfLocation->GetLat(), 
                $getLatAndLongOfLocation->GetLong(), $form->get('distance')->getData(), $this->getUser()->getId());
        }

        return $this->render('index.html.twig',[
            'animalsOfTheUser' => $animalsOfTheUser,
            'rides' => $rides,
            'form' => $form
        ]);
    }    
}