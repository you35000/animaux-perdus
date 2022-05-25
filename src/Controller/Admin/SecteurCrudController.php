<?php

namespace App\Controller\Admin;

use App\Entity\Secteur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SecteurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Secteur::class;
    }
}
