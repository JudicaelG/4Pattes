<?php

namespace App\DTO;

use App\Enum\enumNextRecall;
use DateTime;
use Doctrine\Common\Collections\Collection;

class VaccinatedDTO{

    public int $id;

    public Collection $animal_id;

    public Collection $vaccine_id;

    public ?DateTime $next_recall;

    public ?DateTime $last_date_injection;

    public enumNextRecall $color;
}