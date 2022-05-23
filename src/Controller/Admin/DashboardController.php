<?php

namespace App\Controller\Admin;

use App\Entity\Commune;
use App\Entity\Couleur;
use App\Entity\Departement;
use App\Entity\EspeceAnimal;
use App\Entity\Etat;
use App\Entity\Race;
use App\Entity\Taille;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Etats','fas fa-list',Etat::class);
        yield MenuItem::linkToCrud('Départements','fas fa-list',Departement::class);
        yield MenuItem::linkToCrud('Communes','fas fa-list',Commune::class);
        yield MenuItem::linkToCrud('couleurs','fas fa-list',Couleur::class);
        yield MenuItem::linkToCrud('Espèces d\'animaux','fas fa-list',EspeceAnimal::class);
        yield MenuItem::linkToCrud('Races','fas fa-list',Race::class);
        yield MenuItem::linkToCrud('Tailles','fas fa-list',Taille::class);

    }
}
