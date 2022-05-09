<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/annonces")
 */
class DeclarationController extends AbstractController
{
    /**
     * @Route("/declaration", name="app_declaration")
     */
    public function index(Request $request, EntityManagerInterface $emgr): Response
    {
        return $this->render('declaration/list.html.twig', [
            'controller_name' => 'DeclarationController',
        ]);
    }
}
