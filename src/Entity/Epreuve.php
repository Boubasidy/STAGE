<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\EpreuveRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity(fields:'codeepreuve', message:'This value is already used.')]
#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
class Epreuve
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $codeepreuve = null;

    #[ORM\Column]
    private ?int $numchance = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\Column(length: 20)]
    private ?string $typeepreuve = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $salle = null;

    #[ORM\Column(nullable: true)]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'epreuves')]
    #[ORM\JoinColumn(name:"matiere", referencedColumnName:"codemat")]
    private ?Matiere $matiere = null;

    #[ORM\OneToOne(inversedBy: 'epreuve', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:"element", referencedColumnName:"codeelt")]
    private ?Element $element = null;

    



    public function getCodeepreuve(): ?string
    {
        return $this->codeepreuve;
    }

    public function getNumchance(): ?int
    {
        return $this->numchance;
    }

    public function setNumchance(int $numchance): self
    {
        $this->numchance = $numchance;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getTypeepreuve(): ?string
    {
        return $this->typeepreuve;
    }

    public function setTypeepreuve(string $typeepreuve): self
    {
        $this->typeepreuve = $typeepreuve;

        return $this;
    }

    public function getSalle(): ?string
    {
        return $this->salle;
    }

    public function setSalle(?string $salle): self
    {
        $this->salle = $salle;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getMatiere(): ?Matiere
    {
        return $this->matiere;
    }

    public function setMatiere(?Matiere $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getElement(): ?Element
    {
        return $this->element;
    }

    public function setElement(?Element $element): self
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Set the value of codeepreuve
     *
     * @return  self
     */ 
    public function setCodeepreuve($codeepreuve)
    {
        $this->codeepreuve = $codeepreuve;

        return $this;
    }
}
