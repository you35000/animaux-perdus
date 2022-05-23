<?php

namespace App\Controller\Admin;


use App\Entity\Taille;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TailleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Taille::class;
    }
}
