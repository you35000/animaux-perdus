<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer")
     */
    private $castre;

    /**
     * @ORM\Column(type="integer")
     */
    private $puceElectro;

    /**
     * @ORM\Column(type="integer")
     */
    private $tatouage;

    /**
     * @ORM\Column(type="integer")
     */
    private $collier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $typeCollier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $silhouette;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $taille;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $poils;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $anOuMois;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity=Couleur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $couleurs;

    /**
     * @ORM\ManyToOne(targetEntity=Race::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $races;

    /**
     * @ORM\ManyToOne(targetEntity=EspeceAnimal::class)
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

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCastre(): ?int
    {
        return $this->castre;
    }

    public function setCastre(int $castre): self
    {
        $this->castre = $castre;

        return $this;
    }

    public function getPuceElectro(): ?int
    {
        return $this->puceElectro;
    }

    public function setPuceElectro(int $puceElectro): self
    {
        $this->puceElectro = $puceElectro;

        return $this;
    }

    public function getTatouage(): ?int
    {
        return $this->tatouage;
    }

    public function setTatouage(int $tatouage): self
    {
        $this->tatouage = $tatouage;

        return $this;
    }

    public function getCollier(): ?int
    {
        return $this->collier;
    }

    public function setCollier(int $collier): self
    {
        $this->collier = $collier;

        return $this;
    }

    public function getTypeCollier(): ?int
    {
        return $this->typeCollier;
    }

    public function setTypeCollier(?int $typeCollier): self
    {
        $this->typeCollier = $typeCollier;

        return $this;
    }

    public function getSilhouette(): ?int
    {
        return $this->silhouette;
    }

    public function setSilhouette(?int $silhouette): self
    {
        $this->silhouette = $silhouette;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(?int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPoils(): ?int
    {
        return $this->poils;
    }

    public function setPoils(?int $poils): self
    {
        $this->poils = $poils;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAnOuMois(): ?int
    {
        return $this->anOuMois;
    }

    public function setAnOuMois(?int $anOuMois): self
    {
        $this->anOuMois = $anOuMois;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCouleurs(): ?Couleur
    {
        return $this->couleurs;
    }

    public function setCouleurs(?Couleur $couleurs): self
    {
        $this->couleurs = $couleurs;

        return $this;
    }

    public function getRaces(): ?Race
    {
        return $this->races;
    }

    public function setRaces(?Race $races): self
    {
        $this->races = $races;

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
