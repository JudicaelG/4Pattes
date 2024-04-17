<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals; 
use App\Form\AnimalType;
use App\Service\FileUploader;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'animal')]
    public function index(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::Class);
        $animal = new Animals();
        $animal->SetUserId($this->getUser());
        
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $animal = $form->getData();
            $photoProfile = $form->get('profilePhoto')->getData();
            if($photoProfile){
                $photoProfileName = $fileUploader->upload($photoProfile);
                $animal->setProfilePhoto($photoProfileName);
            }
            $animalInsert = $animalRepository
            ->saveAnimal($animal, $entityManager);

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository
        ->getConnectedUserAnimals($this->getUser()->GetId());
        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'animalsOfUser' => $animalsOfUser
        ]);
    }

    #[Route('/animal/edit/{id}', name: 'edit_animal')]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::Class);
        $animal = $animalRepository->find($id);
        $animal->SetUserId($this->getUser());
        
        $form = $this->createForm(AnimalType::class, $animal);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $animal = $form->getData();

            $animalInsert = $animalRepository
            ->saveAnimal($animal, $entityManager);

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository
        ->getConnectedUserAnimals($this->getUser()->GetId());
        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'animalsOfUser' => $animalsOfUser
        ]);


    }

    #[Route('/animal/delete/{id}', name: 'delete_animal')]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $deleteAnimal = $entityManager->getRepository(Animals::Class)->find($id);
        if(!$deleteAnimal){
            throw $this->createNotFoundException(
                'Pas d\'animal avec cette identifiant'
            );
        }

        $entityManager->remove($deleteAnimal);
        $entityManager->flush();

        return $this->redirectToRoute('animal');
    }

    


}
