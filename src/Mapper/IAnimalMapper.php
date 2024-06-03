<?php

namespace App\Mapper;

use App\DTO\AnimalDTO;
use App\Entity\Animals;
use Doctrine\ORM\PersistentCollection;

interface IAnimalMapper{
    
    public function map($animals): array;

    public function mapAnimal($animal): AnimalDTO;
} 