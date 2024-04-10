<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
class Animals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    private ?Breed $breed_id = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToMany(targetEntity: Vaccinated::class, mappedBy: 'animal_id')]
    private Collection $vaccinateds;

    #[ORM\Column(type: Types::DECIMAL, precision: 7, scale: 3, nullable: true, options:["default" => 0,])]
    private ?string $weight = null;

    public function __construct()
    {
        $this->vaccinateds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBreedId(): ?Breed
    {
        return $this->breed_id;
    }

    public function setBreedId(?Breed $breed_id): static
    {
        $this->breed_id = $breed_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, Vaccinated>
     */
    public function getVaccinateds(): Collection
    {
        return $this->vaccinateds;
    }

    public function addVaccinated(Vaccinated $vaccinated): static
    {
        if (!$this->vaccinateds->contains($vaccinated)) {
            $this->vaccinateds->add($vaccinated);
            $vaccinated->addAnimalId($this);
        }

        return $this;
    }

    public function removeVaccinated(Vaccinated $vaccinated): static
    {
        if ($this->vaccinateds->removeElement($vaccinated)) {
            $vaccinated->removeAnimalId($this);
        }

        return $this;
    }

    public function getAge()
    {
        $now = new \DateTime('now');
        $age = $this->getBirthday();
        $diffence = $now->diff($age);

        return $diffence->format('%y an et %m mois');
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }
}
