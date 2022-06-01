<?php

namespace App\Form\Model;

use App\Entity\Secteur;
use DateTimeInterface;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;

class SearchDeclaration
{
    private ?Secteur $secteur = null;




    /**
     * @return Secteur|null
     */
    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }


    /**
     * @param Secteur|null $secteur
     */
    public function setCampus(?Secteur $secteur): void
    {
        $this->secteur = $secteur;
    }





}
