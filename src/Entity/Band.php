<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BandRepository::class)]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Name is required.', groups: ['create'])]
    private ?string $name = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'Origin is required.', groups: ['create'])]
    private ?string $origin = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: 'City is required.', groups: ['create'])]
    private ?string $city = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank(message: 'Start year is required.', groups: ['create'])]
    #[Assert\Type(type: 'integer', message: 'Start year must be an integer.')]
    #[Assert\Range(notInRangeMessage: 'Start year must be between 1900 and 2100.', min: 1900, max: 2100)]
    private ?int $startYear = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Type(type: 'integer', message: 'Separation year must be an integer.')]
    #[Assert\Range(notInRangeMessage: 'Separation year must be between 1900 and 2100.', min: 1900, max: 2100)]
    private ?int $separationYear = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $founders = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\Type(type: 'integer', message: 'Members must be an integer.')]
    #[Assert\Range(notInRangeMessage: 'Members must be between 1 and 50.', min: 1, max: 50)]
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
