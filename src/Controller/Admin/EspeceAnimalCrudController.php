<?php

namespace App\Controller\Admin;

use App\Entity\EspeceAnimal;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EspeceAnimalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EspeceAnimal::class;
    }


}
