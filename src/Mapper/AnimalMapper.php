<?php

namespace App\Mapper;

use App\DTO\AnimalDTO;
use App\Entity\Animals;
use Doctrine\ORM\PersistentCollection;

use function PHPSTORM_META\map;

class AnimalMapper implements IAnimalMapper{

    public function __construct(private VaccinatedMapper $vaccinatedMapper)
    {
        
    }

    public function map($animals): array{
        $animalsDTO = array();

        foreach($animals as $animal){
            $animalDTO = new AnimalDTO();
            $animalDTO->id = $animal->getId();
            $animalDTO->birthday = $animal->getBirthday();
            $animalDTO->name = $animal->getName();
            $animalDTO->breed_id = $animal->getBreedId();
            $animalDTO->user_id = $animal->getUserId();
            $animalDTO->vaccinated = $this->vaccinatedMapper->map($animal->getVaccinateds());
            $animalDTO->weight = $animal->getWeight();
            $animalDTO->profilePhoto = $animal->getProfilePhoto();

            array_push($animalsDTO, $animalDTO);
        }

        return $animalsDTO;
    }

    public function mapAnimal($animal): AnimalDTO
    {
        $animalDTO = new AnimalDTO;
        $animalDTO->id = $animal->getId();
        $animalDTO->birthday = $animal->getBirthday();
        $animalDTO->name = $animal->getName();
        $animalDTO->breed_id = $animal->getBreedId();
        $animalDTO->user_id = $animal->getUserId();
        $animalDTO->vaccinated = $this->vaccinatedMapper->map($animal->getVaccinateds());
        $animalDTO->weight = $animal->getWeight();
        $animalDTO->profilePhoto = $animal->getProfilePhoto();

        return $animalDTO;
    }
}