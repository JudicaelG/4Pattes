<?php

namespace App\Entity;

use App\Repository\VaccinatedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaccinatedRepository::class)]
class Vaccinated
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: animals::class, inversedBy: 'vaccinateds')]
    private Collection $animal_id;

    #[ORM\ManyToMany(targetEntity: Vaccine::class)]
    private Collection $vaccine_id;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $next_recall = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $last_date_injection = null;

    public function __construct()
    {
        $this->animal_id = new ArrayCollection();
        $this->vaccine_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, animals>
     */
    public function getAnimalId(): Collection
    {
        return $this->animal_id;
    }

    public function addAnimalId(animals $animalId): static
    {
        if (!$this->animal_id->contains($animalId)) {
            $this->animal_id->add($animalId);
        }

        return $this;
    }

    public function removeAnimalId(animals $animalId): static
    {
        $this->animal_id->removeElement($animalId);

        return $this;
    }

    /**
     * @return Collection<int, Vaccine>
     */
    public function getVaccineId(): Collection
    {
        return $this->vaccine_id;
    }

    public function addVaccineId(Vaccine $vaccineId): static
    {
        if (!$this->vaccine_id->contains($vaccineId)) {
            $this->vaccine_id->add($vaccineId);
        }

        return $this;
    }

    public function removeVaccineId(Vaccine $vaccineId): static
    {
        $this->vaccine_id->removeElement($vaccineId);

        return $this;
    }

    public function getNextRecall(): ?\DateTimeInterface
    {
        return $this->next_recall;
    }

    public function setNextRecall(\DateTimeInterface $next_recall): static
    {
        $this->next_recall = $next_recall;

        return $this;
    }

    public function getLastDateInjection(): ?\DateTimeInterface
    {
        return $this->last_date_injection;
    }

    public function setLastDateInjection(?\DateTimeInterface $last_date_injection): static
    {
        $this->last_date_injection = $last_date_injection;

        return $this;
    }

    public function __toString()
    {
        return $this->vaccine_id->name;
    }
}
