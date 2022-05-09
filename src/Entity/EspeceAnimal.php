<?php

namespace App\Entity;

use App\Repository\EspeceAnimalRepository;
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
     * @ORM\Column(type="string", length=2)
     */
    private $codeAnimal;

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

    public function getCodeAnimal(): ?string
    {
        return $this->codeAnimal;
    }

    public function setCodeAnimal(string $codeAnimal): self
    {
        $this->codeAnimal = $codeAnimal;

        return $this;
    }
}
