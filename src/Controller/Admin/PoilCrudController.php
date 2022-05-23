<?php

namespace App\Controller\Admin;

use App\Entity\Poil;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PoilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Poil::class;
    }
}
