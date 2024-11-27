<?php

namespace App\Entity;

use App\Repository\LostAnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LostAnimalRepository::class)]
class LostAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Description')]
    private ?Animals $animal_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?bool $Peureux = null;

    #[ORM\Column]
    private ?bool $Agressif = null;

    #[ORM\Column(length: 255)]
    private ?string $Lieu = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 10)]
    private ?string $Lon = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 10)]
    private ?string $lat = null;

    #[ORM\Column]
    private ?int $Numero_icad = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Trouver = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getAnimalId(): ?Animals
    {
        return $this->animal_id;
    }

    public function setAnimalId(?Animals $animal_id): static
    {
        $this->animal_id = $animal_id;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function isPeureux(): ?bool
    {
        return $this->Peureux;
    }

    public function setPeureux(bool $Peureux): static
    {
        $this->Peureux = $Peureux;

        return $this;
    }

    public function isAgressif(): ?bool
    {
        return $this->Agressif;
    }

    public function setAgressif(bool $Agressif): static
    {
        $this->Agressif = $Agressif;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->Lieu;
    }

    public function setLieu(string $Lieu): static
    {
        $this->Lieu = $Lieu;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->Lon;
    }

    public function setLon(string $Lon): static
    {
        $this->Lon = $Lon;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): static
    {
        $this->lat = $lat;

        return $this;
    }

    public function getNumeroIcad(): ?int
    {
        return $this->Numero_icad;
    }

    public function setNumeroIcad(int $Numero_icad): static
    {
        $this->Numero_icad = $Numero_icad;

        return $this;
    }

    public function isTrouver(): ?bool
    {
        return $this->Trouver;
    }

    public function setTrouver(?bool $Trouver): static
    {
        $this->Trouver = $Trouver;

        return $this;
    }
}
