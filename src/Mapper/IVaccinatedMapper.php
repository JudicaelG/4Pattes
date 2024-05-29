<?php

namespace App\Mapper;

use App\Entity\Vaccinated;
use Doctrine\ORM\PersistentCollection;

interface IVaccinatedMapper{
    
    public function map($vaccinated): array;
} 