<?php

namespace App\Entity;

use App\Repository\VacatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VacatureRepository::class)
 */
class Vacature
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
    private $titel;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $omschrijving;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datum;

    /**
     * @ORM\OneToMany(targetEntity=Sollicitatie::class, mappedBy="vacature")
     */
    private $sollicitaties;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vacatures")
     */
    private $userWG;

    /**
     * @ORM\ManyToOne(targetEntity=Platform::class, inversedBy="vacatures")
     */
    private $platform;

    public function __construct()
    {
        $this->sollicitaties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitel(): ?string
    {
        return $this->titel;
    }

    public function setTitel(?string $titel): self
    {
        $this->titel = $titel;

        return $this;
    }

    public function getOmschrijving(): ?string
    {
        return $this->omschrijving;
    }

    public function setOmschrijving(?string $omschrijving): self
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

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

    /**
     * @return Collection|Sollicitatie[]
     */
    public function getSollicitaties(): Collection
    {
        return $this->sollicitaties;
    }

    public function addSollicitaty(Sollicitatie $sollicitaty): self
    {
        if (!$this->sollicitaties->contains($sollicitaty)) {
            $this->sollicitaties[] = $sollicitaty;
            $sollicitaty->setVacature($this);
        }

        return $this;
    }

    public function removeSollicitaty(Sollicitatie $sollicitaty): self
    {
        if ($this->sollicitaties->removeElement($sollicitaty)) {
            // set the owning side to null (unless already changed)
            if ($sollicitaty->getVacature() === $this) {
                $sollicitaty->setVacature(null);
            }
        }

        return $this;
    }

    public function getUserWG(): ?User
    {
        return $this->userWG;
    }

    public function setUserWG(?User $userWG): self
    {
        $this->userWG = $userWG;

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

}
