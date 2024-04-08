<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals; 
use App\Form\AnimalType;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'animal')]
    public function index(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/new', name: 'new_animal')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animals();
        $animal->SetUserId($this->getUser());
        
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $animal = $form->getData();

            $animalInsert = $entityManager->getRepository(Animals::Class)
            ->saveAnimal($animal, $entityManager);
        }

        return $this->render('animal/new.html.twig', [
            'form' => $form,
        ]);


    }


}
