<?php

namespace App\Entity;

use App\Repository\EspeceAnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EspeceAnimalRepository::class)
 */
class EspeceAnimal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Race::class, mappedBy="especes")
     */
    private $races;

    public function __construct()
    {
        $this->races = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Race>
     */
    public function getRaces(): Collection
    {
        return $this->races;
    }

    public function addRace(Race $race): self
    {
        if (!$this->races->contains($race)) {
            $this->races[] = $race;
            $race->setEspeces($this);
        }

        return $this;
    }

    public function removeRace(Race $race): self
    {
        if ($this->races->removeElement($race)) {
            // set the owning side to null (unless already changed)
            if ($race->getEspeces() === $this) {
                $race->setEspeces(null);
            }
        }

        return $this;
    }


}
