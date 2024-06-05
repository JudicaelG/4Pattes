<?php

namespace App\DTO;

use App\Entity\Breed;
use App\Entity\User;
use DateTime;

class AnimalDTO{
    public int $id;
    
    public string $name;

    public DateTime $birthday;

    public Breed $breed_id;

    public User $user_id;

    public array $vaccinated;
    
    public string $weight;

    public ?string $sexe;

    public ?bool $sterilized;
    
    public ?string $profilePhoto;

    public function getAge()
    {
        $now = new \DateTime('now');
        $age = $this->birthday;
        $diffence = $now->diff($age);

        return $diffence->format('%y an et %m mois');
    }
}