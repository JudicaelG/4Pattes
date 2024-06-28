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
use App\Entity\Veterinary;
use App\Form\AnimalCatEditType;
use App\Form\AnimalCatType;
use App\Form\AnimalEditType;
use App\Form\AnimalType;
use App\Form\VeterinaryModifyType;
use App\Form\VeterinaryType;
use App\Mapper\AnimalMapper;
use App\Service\AddVaccinated;
use App\Service\FileUploader;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'animal')]
    public function index(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, AddVaccinated $addVaccinated, AnimalMapper $animalMapper): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::class);
        $vaccins = $entityManager->getRepository(Vaccine::class)->findAll();
        $veterinaryOfUser = $entityManager->getRepository(Veterinary::class)->findOneByUser($this->getUser());
        $dog = new Animals();
        $cat = new Animals();

        $dog = $addVaccinated->AddAllVaccineToAnimal($dog, $vaccins, 'chien');
        $cat = $addVaccinated->AddAllVaccineToAnimal($cat, $vaccins, 'chat');

        $dog->SetUserId($this->getUser());
        $cat->SetUserId($this->getUser());

        $form = $this->createForm(AnimalType::class, $dog, ['veterinary' => $veterinaryOfUser]);
        $formCat = $this->createForm(AnimalCatType::class, $cat, ['veterinary' => $veterinaryOfUser]);
        
        $form->handleRequest($request);
        $formCat->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $animal = $form->getData();

            if($form->has('add_veterinary')){
                $veterinary = new Veterinary();
                $veterinary = $form['add_veterinary']->getData();
                $veterinary->setUserId($this->getUser());
                $entityManager->persist($veterinary);
                $animal->setVeterinary($veterinary);
            } 
            
            $photoProfile = $form->get('profilePhoto')->getData();
            if($photoProfile){
                $photoProfileName = $fileUploader->upload($photoProfile);
                $animal->setProfilePhoto($photoProfileName);
            }
            foreach($animal->getVaccinateds() as $vaccinated){
                if($vaccinated->getLastDateInjection() != null){
                    $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
                }
            }
            $entityManager->flush();
            $animalInsert = $animalRepository
            ->saveAnimal($animal);

            if($animalInsert->getStatusCode() == 200){
                $this->addFlash('success', $animalInsert->getContent());
            }

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
            
            $animalInsert = $animalRepository
            ->saveAnimal($animal);

            if($animalInsert->getStatusCode() == 200){
                $this->addFlash('success', $animalInsert->getContent());
            }

            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalMapper->map($animalRepository        
        ->getConnectedUserAnimals($this->getUser()));

        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'formCat' => $formCat,
            'animalTypeCat' => false,
            'animalsOfUser' => $animalsOfUser
        ]);
    }

    #[Route('/animal/{id}', name: 'card_animal')]
    public function animalCard(EntityManagerInterface $entityManager, int $id, AnimalMapper $animalMapper): Response{
        $animal = $animalMapper->mapAnimal($entityManager->getRepository(Animals::class)->getAnimalWithVaccineAndVaccineDateAndVeterinary($id));

        $form = $this->createForm(VeterinaryModifyType::class, $animal->veterinary, ['action' => $this->generateUrl('app_veterinary_edit', ['id' => $animal->veterinary->getId()])]);


        return $this->render('animal/card.html.twig',[
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/animal/edit/{id}', name: 'edit_animal')]
    public function new(Request $request, EntityManagerInterface $entityManager, int $id, AddVaccinated $addVaccinated, AnimalMapper $animalMapper): Response
    {
        $animalRepository = $entityManager->getRepository(Animals::class);
        $animal = $animalRepository->getAnimalWithVaccineAndVaccineDate($id);
        $animalTypeCat = false;
        $veterinaryOfUser = $entityManager->getRepository(Veterinary::class)->findOneByUser($this->getUser());
        $formCat = $this->createForm(AnimalCatEditType::class);
        $form = $this->createForm(AnimalEditType::class);

        if(!$animal){
            return $this->redirectToRoute('animal');
        }

        if($animal->getBreedId()->gettype() == 'cat'){
            $animalTypeCat = true;
            $formCat = $this->createForm(AnimalCatEditType::class, $animal, ['veterinary' => $veterinaryOfUser]);
        }else{
            $form = $this->createForm(AnimalEditType::class, $animal, ['veterinary' => $veterinaryOfUser]);
        }
        
        $form->handleRequest($request);
        $formCat->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $animal = $form->getData();
            foreach($animal->getVaccinateds() as $vaccinated){
                $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
            }

            $entityManager->flush();
            $this->addFlash('success', 'Votre animal a bien été modifié');
            return $this->redirectToRoute('animal');
        }

        if($formCat->isSubmitted() && $formCat->isValid()){

            $animal = $formCat->getData();
            foreach($animal->getVaccinateds() as $vaccinated){
                $animal->addVaccinated($addVaccinated->RecalculNextRecall($vaccinated));
            }

            $entityManager->flush();
            $this->addFlash('success', 'Votre animal a bien été modifié');
            return $this->redirectToRoute('animal');
        }

        $animalsOfUser = $animalMapper->map($animalRepository        
        ->getConnectedUserAnimals($this->getUser()));
        return $this->render('animal/index.html.twig', [
            'form' => $form,
            'formCat' => $formCat,
            'animalTypeCat' => $animalTypeCat,
            'animalsOfUser' => $animalsOfUser,
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
        $this->addFlash('warning', 'Votre animal a bien été supprimé');
        return $this->redirectToRoute('animal');
    }

    


}
