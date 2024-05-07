<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals;
use App\Entity\Vaccinated;
use App\Form\AnimalEditType;
use App\Form\AnimalType;
use App\Form\EditVaccineDateAnimalType;
use App\Form\VaccineRelationshipType;
use App\Service\AddVaccinated;
use App\Service\FileUploader;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'animal')]
    public function index(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, AddVaccinated $addVaccinated): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::class);
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
            ->saveAnimal($animal, $entityManager, $addVaccinated, $form->get('vaccine_id')->getData(), $form->get('vaccine_date'));

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository        
        ->getConnectedUserAnimals($this->getUser()->getId());

        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'animalsOfUser' => $animalsOfUser
        ]);
    }

    #[Route('/animal/edit/{id}', name: 'edit_animal')]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, AddVaccinated $addVaccinated): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::class);
        $animal = $animalRepository->getAnimalWithVaccineAndVaccineDate($id);
        $form = $this->createForm(AnimalEditType::class, $animal);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $animal = $form->getData();
            
            $animalInsert = $animalRepository
            ->saveAnimal($animal, $entityManager, $addVaccinated, null, null );

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository
        ->getConnectedUserAnimals($this->getUser()->GetId());
        return $this->render('animal/edit.html.twig', [
            'form' => $form,
            'animalsOfUser' => $animalsOfUser
        ]);


    }

    #[Route('/animal/delete/{id}', name: 'delete_animal')]
    public function delete(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $deleteAnimal = $entityManager->getRepository(Animals::class)->find($id);
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
