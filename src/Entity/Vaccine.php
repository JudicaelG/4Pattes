<?php

namespace App\Entity;

use App\Repository\VaccineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VaccineRepository::class)]
class Vaccine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Week_2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Week_4 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Week_6 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Month_2 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Month_3 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Month_4 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Month_5 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Month_6 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $year_1 = null;

    #[ORM\Column(nullable: true)]
    private ?bool $annual_recall = null;

    #[ORM\Column(nullable: true)]
    private ?bool $annual_3_recall = null;

    #[ORM\Column(length: 6, options: ["default" => 'chien'])]
    private ?string $type = null;

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

    public function isWeek2(): ?bool
    {
        return $this->Week_2;
    }

    public function setWeek2(?bool $Week_2): static
    {
        $this->Week_2 = $Week_2;

        return $this;
    }

    public function isWeek4(): ?bool
    {
        return $this->Week_4;
    }

    public function setWeek4(?bool $Week_4): static
    {
        $this->Week_4 = $Week_4;

        return $this;
    }

    public function isWeek6(): ?bool
    {
        return $this->Week_6;
    }

    public function setWeek6(?bool $Week_6): static
    {
        $this->Week_6 = $Week_6;

        return $this;
    }

    public function isMonth2(): ?bool
    {
        return $this->Month_2;
    }

    public function setMonth2(?bool $Month_2): static
    {
        $this->Month_2 = $Month_2;

        return $this;
    }

    public function isMonth3(): ?bool
    {
        return $this->Month_3;
    }

    public function setMonth3(?bool $Month_3): static
    {
        $this->Month_3 = $Month_3;

        return $this;
    }

    public function isMonth4(): ?bool
    {
        return $this->Month_4;
    }

    public function setMonth4(?bool $Month_4): static
    {
        $this->Month_4 = $Month_4;

        return $this;
    }

    public function isMonth5(): ?bool
    {
        return $this->Month_5;
    }

    public function setMonth5(?bool $Month_5): static
    {
        $this->Month_5 = $Month_5;

        return $this;
    }

    public function isMonth6(): ?bool
    {
        return $this->Month_6;
    }

    public function setMonth6(?bool $Month_6): static
    {
        $this->Month_6 = $Month_6;

        return $this;
    }

    public function isYear1(): ?bool
    {
        return $this->year_1;
    }

    public function setYear1(?bool $year_1): static
    {
        $this->year_1 = $year_1;

        return $this;
    }

    public function isAnnualRecall(): ?bool
    {
        return $this->annual_recall;
    }

    public function setAnnualRecall(?bool $annual_recall): static
    {
        $this->annual_recall = $annual_recall;

        return $this;
    }

    public function isAnnual3Recall(): ?bool
    {
        return $this->annual_3_recall;
    }

    public function setAnnual3Recall(?bool $annual_3_recall): static
    {
        $this->annual_3_recall = $annual_3_recall;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }
}
