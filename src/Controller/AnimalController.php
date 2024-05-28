<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Animals;
use App\Entity\Vaccinated;
use App\Entity\Vaccine;
use App\Form\AnimalCatType;
use App\Form\AnimalEditType;
use App\Form\AnimalType;
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
        $formCat = $this->createForm(AnimalCatType::class, $animal);
        
        $form->handleRequest($request);
        $formCat->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $animal = $form->getData();
            $photoProfile = $form->get('profilePhoto')->getData();
            if($photoProfile){
                $photoProfileName = $fileUploader->upload($photoProfile);
                $animal->setProfilePhoto($photoProfileName);
            }
            foreach($animal->getVaccinateds() as $vaccinated){
                if($vaccinated->getLastDateInjection()){
                    $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
                }
            }
            //$animal = $addVaccinated->AddVaccine($form->get('vaccine_id')->getData(), $form->get('vaccine_date'), $animal);   
            $animalInsert = $animalRepository
            ->saveAnimal($animal);

            return $this->redirectToRoute('animal');
        }
        if($formCat->isSubmitted() && $formCat->isValid()){

            $animal = $formCat->getData();
            $photoProfile = $formCat->get('profilePhoto')->getData();
            if($photoProfile){
                $photoProfileName = $fileUploader->upload($photoProfile);
                $animal->setProfilePhoto($photoProfileName);
            }
            foreach($animal->getVaccinateds() as $vaccinated){
                if($vaccinated->getLastDateInjection()){
                    $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
                }
            }
            //$animal = $addVaccinated->AddVaccine($form->get('vaccine_id')->getData(), $form->get('vaccine_date'), $animal);   
            $animalInsert = $animalRepository
            ->saveAnimal($animal);

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository        
        ->getConnectedUserAnimals($this->getUser());

        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'formCat' => $formCat,
            'animalTypeCat' => false,
            'animalsOfUser' => $animalsOfUser
        ]);
    }

    #[Route('/animal/edit/{id}', name: 'edit_animal')]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, AddVaccinated $addVaccinated): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::class);
        $animal = $animalRepository->getAnimalWithVaccineAndVaccineDate($id);
        $animalTypeCat = false;
        $formCat = $this->createForm(AnimalCatType::class);
        $form = $this->createForm(AnimalEditType::class);

        if(!$animal){
            return $this->redirectToRoute('animal');
        }

        if($animal->getBreedId()->gettype() == 'cat'){
            $animalTypeCat = true;
            $formCat = $this->createForm(AnimalCatType::class, $animal);
        }else{
            $form = $this->createForm(AnimalEditType::class, $animal);
        }

        
        $form->handleRequest($request);
        $formCat->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $animal = $form->getData();
            foreach($animal->getVaccinateds() as $vaccinated){
                $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
            }

            $entityManager->flush();

            return $this->redirectToRoute('animal');
        }

        if($formCat->isSubmitted() && $formCat->isValid()){


            $animal = $formCat->getData();
            foreach($animal->getVaccinateds() as $vaccinated){
                $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
            }

            $entityManager->flush();

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalRepository
        ->getConnectedUserAnimals($this->getUser());
        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'formCat' => $formCat,
            'animalTypeCat' => $animalTypeCat,
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
