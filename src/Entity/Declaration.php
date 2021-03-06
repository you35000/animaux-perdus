<?php

namespace App\Entity;

use App\Repository\DeclarationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $dateHeureD;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $infoSupp;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="declarations")
     ** @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="declarations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etats;

    /**
     * @ORM\ManyToOne(targetEntity=Secteur::class, inversedBy="declarations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $secteurs;

    /**
     * @ORM\ManyToOne(targetEntity=Animal::class, inversedBy="declarations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $animaux;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="declarations")
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeureD(): ?\DateTimeInterface
    {
        return $this->dateHeureD;
    }

    public function setDateHeureD(\DateTimeInterface $dateHeureD): self
    {
        $this->dateHeureD = $dateHeureD;

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

    public function getEtats(): ?Etat
    {
        return $this->etats;
    }

    public function setEtats(?Etat $etats): self
    {
        $this->etats = $etats;

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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setDeclarations($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getDeclarations() === $this) {
                $commentaire->setDeclarations(null);
            }
        }

        return $this;
    }


}
