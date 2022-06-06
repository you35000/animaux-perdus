<?php

namespace App\Model;

use App\Entity\Secteur;

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
