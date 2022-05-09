<?php

namespace App\Entity;

use App\Repository\DeclarationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeclarationRepository::class)
 */
class Declaration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeureDispar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoSupp;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteurs;

    /**
     * @ORM\ManyToOne(targetEntity=Animal::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $animaux;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $etats;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureDispar(): ?\DateTimeInterface
    {
        return $this->dateHeureDispar;
    }

    public function setDateHeureDispar(\DateTimeInterface $dateHeureDispar): self
    {
        $this->dateHeureDispar = $dateHeureDispar;

        return $this;
    }

    public function getInfoSupp(): ?string
    {
        return $this->infoSupp;
    }

    public function setInfoSupp(?string $infoSupp): self
    {
        $this->infoSupp = $infoSupp;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getSecteurs(): ?Secteur
    {
        return $this->secteurs;
    }

    public function setSecteurs(?Secteur $secteurs): self
    {
        $this->secteurs = $secteurs;

        return $this;
    }

    public function getAnimaux(): ?Animal
    {
        return $this->animaux;
    }

    public function setAnimaux(?Animal $animaux): self
    {
        $this->animaux = $animaux;

        return $this;
    }

    public function getEtats(): ?Etat
    {
        return $this->etats;
    }

    public function setEtats(?Etat $etats): self
    {
        $this->etats = $etats;

        return $this;
    }
}
