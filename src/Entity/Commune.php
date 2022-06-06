<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CommuneRepository::class)
 */
class Commune
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commune"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"commune"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"commune"})
     */
    private $codepostal;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class)
     * @ORM\JoinColumn(nullable=false)
     */

    private $departements;

    /**
     * @ORM\OneToMany(targetEntity=Secteur::class, mappedBy="commune")
     */
    private $secteurs;

    public function __construct()
    {
        $this->secteurs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCodepostal(): ?string
    {
        return $this->codepostal;
    }

    public function setCodepostal(string $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getDepartements(): ?Departement
    {
        return $this->departements;
    }

    public function setDepartements(?Departement $departements): self
    {
        $this->departements = $departements;

        return $this;
    }
    /**
     * @return Collection|Secteur[]
     */
    public function getSecteurs(): Collection
    {
        return $this->secteurs;
    }

    public function addSecteur(Secteur $secteur): self
    {
        if (!$this->secteurs->contains($secteur)) {
            $this->secteurs[] = $secteur;
            $secteur->setCommunes($this);
        }

        return $this;
    }

    public function removeSecteur(Secteur $secteur): self
    {
        if ($this->secteurs->removeElement($secteur)) {
            // set the owning side to null (unless already changed)
            if ($secteur->getCommunes() === $this) {
                $secteur->setCommunes(null);
            }
        }

        return $this;
    }
}
