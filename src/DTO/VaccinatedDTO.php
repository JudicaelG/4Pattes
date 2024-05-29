<?php

namespace App\DTO;

use App\Entity\Animals;
use App\Entity\Vaccine;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

enum nextRecall {
    case green;
    case orange;
    case red;
}

class VaccinatedDTO{

    public int $id;

    public Collection $animal_id;

    public Collection $vaccine_id;

    public ?DateTime $next_recall;

    public ?DateTime $last_date_injection;

    public nextRecall $color;
}