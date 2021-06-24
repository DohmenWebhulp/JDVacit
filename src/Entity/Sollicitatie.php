<?php

namespace App\Entity;

use App\Repository\SollicitatieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SollicitatieRepository::class)
 */
class Sollicitatie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $cv;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motivatie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sollicitaties")
     */
    private $userWN;

    /**
     * @ORM\ManyToOne(targetEntity=Vacature::class, inversedBy="sollicitaties")
     */
    private $vacature;

    /**
     * @ORM\Column(type="boolean")
     */
    private $uitnodiging;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $datum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): self
    {
        $this->cv = $cv;

        return $this;
    }

    public function getMotivatie(): ?string
    {
        return $this->motivatie;
    }

    public function setMotivatie(?string $motivatie): self
    {
        $this->motivatie = $motivatie;

        return $this;
    }

    public function getUserWN(): ?User
    {
        return $this->userWN;
    }

    public function setUserWN(?User $userWN): self
    {
        $this->userWN = $userWN;

        return $this;
    }

    public function getVacature(): ?Vacature
    {
        return $this->vacature;
    }

    public function setVacature(?Vacature $vacature): self
    {
        $this->vacature = $vacature;

        return $this;
    }

    public function getUitnodiging(): ?bool
    {
        return $this->uitnodiging;
    }

    public function setUitnodiging(bool $uitnodiging): self
    {
        $this->uitnodiging = $uitnodiging;

        return $this;
    }

    public function getDatum(): ?\DateTimeInterface
    {
        return $this->datum;
    }

    public function setDatum(?\DateTimeInterface $datum): self
    {
        $this->datum = $datum;

        return $this;
    }
}
