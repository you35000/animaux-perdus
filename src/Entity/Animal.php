<?php


namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalRepository::class)
 */
class Animal
{
    const SEXE = [
        "M" => "Male",
        "F" => "Femelle",
    ];


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
     * @ORM\Column(type="boolean")
     */
    private $sexe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $castre;

    /**
     * @ORM\Column(type="boolean")
     */
    private $puceElectro;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tatouage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $collier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="boolean")
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
     * @ORM\ManyToOne(targetEntity=Poil::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $poils;

    /**
     * @ORM\ManyToOne(targetEntity=TypeCollier::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $TypeColliers;

    /**
     * @ORM\ManyToOne(targetEntity=Croisement::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $croisements;

    /**
     * @ORM\ManyToOne(targetEntity=Silhouette::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $silhouettes;

    /**
     * @ORM\ManyToOne(targetEntity=Taille::class, inversedBy="animals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tailles;

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

    public function getPoils(): ?Poil
    {
        return $this->poils;
    }

    public function setPoils(?Poil $poils): self
    {
        $this->poils = $poils;

        return $this;
    }

    public function getTypeColliers(): ?TypeCollier
    {
        return $this->TypeColliers;
    }

    public function setTypeColliers(?TypeCollier $TypeColliers): self
    {
        $this->TypeColliers = $TypeColliers;

        return $this;
    }

    public function getSexeLibelle(): string
    {
        $currentSexe = $this->getSexe();

        return ($currentSexe) ? self::SEXE['M'] : self::SEXE['F'];
    }

    public function getCroisements(): ?Croisement
    {
        return $this->croisements;
    }

    public function setCroisements(?Croisement $croisements): self
    {
        $this->croisements = $croisements;

        return $this;
    }

    public function getSilhouettes(): ?Silhouette
    {
        return $this->silhouettes;
    }

    public function setSilhouettes(?Silhouette $silhouettes): self
    {
        $this->silhouettes = $silhouettes;

        return $this;
    }

    public function getTailles(): ?Taille
    {
        return $this->tailles;
    }

    public function setTailles(?Taille $tailles): self
    {
        $this->tailles = $tailles;

        return $this;
    }

}

//
//namespace App\Entity;
//
//use App\Repository\AnimalRepository;
//use Doctrine\ORM\Mapping as ORM;
//
///**
// * @ORM\Entity(repositoryClass=AnimalRepository::class)
// */
//class Animal
//{
//    const SEXE = [
//        "M" => "Male",
//        "F" => "Femelle",
//    ];
//
//
//    /**
//     * @ORM\Id
//     * @ORM\GeneratedValue
//     * @ORM\Column(type="integer")
//     */
//    private $id;
//
//    /**
//     * @ORM\Column(type="string", length=25)
//     */
//    private $nom;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $sexe;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $castre;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $puceElectro;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $tatouage;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $collier;
//
//
//
//    /**
//     * @ORM\Column(type="string", length=25)
//     */
//    private $silhouette;
//
//    /**
//     * @ORM\Column(type="string", length=25)
//     */
//    private $taille;
//
//    /**
//     * @ORM\Column(type="integer", nullable=true)
//     */
//    private $age;
//
//    /**
//     * @ORM\Column(type="boolean")
//     */
//    private $anOuMois;
//
//    /**
//     * @ORM\Column(type="string", length=255, nullable=true)
//     */
//    private $photo;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Couleur::class)
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $couleurs;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Race::class)
//     * @ORM\JoinColumn(nullable=true)
//     */
//    private $races;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Poil::class)
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $poils;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=TypeCollier::class)
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $TypeColliers;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Croisement::class, inversedBy="animals")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $croisements;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Silhouette::class, inversedBy="animals")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $silhouettes;
//
//    /**
//     * @ORM\ManyToOne(targetEntity=Taille::class, inversedBy="animals")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $tailles;
//
//    public function getId(): ?int
//    {
//        return $this->id;
//    }
//
//    public function getNom(): ?string
//    {
//        return $this->nom;
//    }
//
//    public function setNom(string $nom): self
//    {
//        $this->nom = $nom;
//
//        return $this;
//    }
//
//    public function getSexe(): ?int
//    {
//        return $this->sexe;
//    }
//
//    public function setSexe(int $sexe): self
//    {
//        $this->sexe = $sexe;
//
//        return $this;
//    }
//
//    public function getCastre(): ?int
//    {
//        return $this->castre;
//    }
//
//    public function setCastre(int $castre): self
//    {
//        $this->castre = $castre;
//
//        return $this;
//    }
//
//    public function getPuceElectro(): ?int
//    {
//        return $this->puceElectro;
//    }
//
//    public function setPuceElectro(int $puceElectro): self
//    {
//        $this->puceElectro = $puceElectro;
//
//        return $this;
//    }
//
//    public function getTatouage(): ?int
//    {
//        return $this->tatouage;
//    }
//
//    public function setTatouage(int $tatouage): self
//    {
//        $this->tatouage = $tatouage;
//
//        return $this;
//    }
//
//    public function getCollier(): ?int
//    {
//        return $this->collier;
//    }
//
//    public function setCollier(int $collier): self
//    {
//        $this->collier = $collier;
//
//        return $this;
//    }
//
//
//    public function getSilhouette(): ?string
//    {
//        return $this->silhouette;
//    }
//
//    public function setSilhouette(?string $silhouette): self
//    {
//        $this->silhouette = $silhouette;
//
//        return $this;
//    }
//
//    public function getTaille(): ?string
//    {
//        return $this->taille;
//    }
//
//    public function setTaille(?string $taille): self
//    {
//        $this->taille = $taille;
//
//        return $this;
//    }
//
//    public function getAge(): ?int
//    {
//        return $this->age;
//    }
//
//    public function setAge(?int $age): self
//    {
//        $this->age = $age;
//
//        return $this;
//    }
//
//    public function getAnOuMois(): ?int
//    {
//        return $this->anOuMois;
//    }
//
//    public function setAnOuMois(?int $anOuMois): self
//    {
//        $this->anOuMois = $anOuMois;
//
//        return $this;
//    }
//
//    public function getPhoto(): ?string
//    {
//        return $this->photo;
//    }
//
//    public function setPhoto(?string $photo): self
//    {
//        $this->photo = $photo;
//
//        return $this;
//    }
//
//    public function getCouleurs(): ?Couleur
//    {
//        return $this->couleurs;
//    }
//
//    public function setCouleurs(?Couleur $couleurs): self
//    {
//        $this->couleurs = $couleurs;
//
//        return $this;
//    }
//
//    public function getRaces(): ?Race
//    {
//        return $this->races;
//    }
//
//    public function setRaces(?Race $races): self
//    {
//        $this->races = $races;
//
//        return $this;
//    }
//
//    public function getPoils(): ?Poil
//    {
//        return $this->poils;
//    }
//
//    public function setPoils(?Poil $poils): self
//    {
//        $this->poils = $poils;
//
//        return $this;
//    }
//
//    public function getTypeColliers(): ?TypeCollier
//    {
//        return $this->TypeColliers;
//    }
//
//    public function setTypeColliers(?TypeCollier $TypeColliers): self
//    {
//        $this->TypeColliers = $TypeColliers;
//
//        return $this;
//    }
//
//    public function getSexeLibelle(): string {
//        $currentSexe = $this->getSexe();
//
//        return ($currentSexe) ? self::SEXE['M'] : self::SEXE['F'];
//    }
//
//    public function getCroisements(): ?Croisement
//    {
//        return $this->croisements;
//    }
//
//    public function setCroisements(?Croisement $croisements): self
//    {
//        $this->croisements = $croisements;
//
//        return $this;
//    }
//
//    public function getSilhouettes(): ?Silhouette
//    {
//        return $this->silhouettes;
//    }
//
//    public function setSilhouettes(?Silhouette $silhouettes): self
//    {
//        $this->silhouettes = $silhouettes;
//
//        return $this;
//    }
//
//    public function getTailles(): ?Taille
//    {
//        return $this->tailles;
//    }
//
//    public function setTailles(?Taille $tailles): self
//    {
//        $this->tailles = $tailles;
//
//        return $this;
//    }
//
//}
