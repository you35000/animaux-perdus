<?php

namespace App\Entity;

use App\Repository\SecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SecteurRepository::class)
 */
class Secteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"secteur"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"secteur"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ({"secteur"})
     * @Assert\NotBlank()
     */
    private $adresse;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups ({"secteur"})
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups ({"secteur"})
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity=Commune::class, inversedBy="secteurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $communes;

    /**
     * @ORM\OneToMany(targetEntity=Declaration::class, mappedBy="secteurs")
     */
    private $declarations;

    public function __construct()
    {
        $this->declarations = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->getNom();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCommunes(): ?Commune
    {
        return $this->communes;
    }

    public function setCommunes(?Commune $communes): self
    {
        $this->communes = $communes;

        return $this;
    }

    /**
     * @return Collection<int, Declaration>
     */
    public function getDeclarations(): Collection
    {
        return $this->declarations;
    }

    public function addDeclaration(Declaration $declaration): self
    {
        if (!$this->declarations->contains($declaration)) {
            $this->declarations[] = $declaration;
            $declaration->setSecteurs($this);
        }

        return $this;
    }

    public function removeDeclaration(Declaration $declaration): self
    {
        if ($this->declarations->removeElement($declaration)) {
            // set the owning side to null (unless already changed)
            if ($declaration->getSecteurs() === $this) {
                $declaration->setSecteurs(null);
            }
        }

        return $this;
    }
}
