<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    private ?string $origin = null;

    #[ORM\Column(length: 30)]
    private ?string $city = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $startYear = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $separationYear = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $founders = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $members = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $musicalCurrent = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $presentation = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStartYear(): ?int
    {
        return $this->startYear;
    }

    public function setStartYear(int $startYear): static
    {
        $this->startYear = $startYear;

        return $this;
    }

    public function getSeparationYear(): ?int
    {
        return $this->separationYear;
    }

    public function setSeparationYear(?int $separationYear): static
    {
        $this->separationYear = $separationYear;

        return $this;
    }

    public function getFounders(): ?string
    {
        return $this->founders;
    }

    public function setFounders(?string $founders): static
    {
        $this->founders = $founders;

        return $this;
    }

    public function getMembers(): ?int
    {
        return $this->members;
    }

    public function setMembers(?int $members): static
    {
        $this->members = $members;

        return $this;
    }

    public function getMusicalCurrent(): ?string
    {
        return $this->musicalCurrent;
    }

    public function setMusicalCurrent(?string $musicalCurrent): static
    {
        $this->musicalCurrent = $musicalCurrent;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): static
    {
        $this->presentation = $presentation;

        return $this;
    }
}
