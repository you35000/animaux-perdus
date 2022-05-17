<?php

namespace App\Entity;

use App\Repository\RaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RaceRepository::class)
 */
class Race
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity=EspeceAnimal::class, inversedBy="races")
     * @ORM\JoinColumn(nullable=false)
     */
    private $especes;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getEspeces(): ?EspeceAnimal
    {
        return $this->especes;
    }

    public function setEspeces(?EspeceAnimal $especes): self
    {
        $this->especes = $especes;

        return $this;
    }
}
