<?php

namespace App\Controller;

use App\Entity\Secteur;
use App\Repository\CommuneRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/villes", name="villes_get", methods={"GET"})
     */
    public function getCommunes(CommuneRepository $communeRepository): JsonResponse
    {
        return $this->json($communeRepository->findAll());
    }

    /**
     * @Route("/secteurs", name="secteurs_get", methods={"GET"})
     */
    public function getSecteurs(SecteurRepository $secteurRepository): Response
    {
        return $this->json($secteurRepository->findAll());
    }

    /**
     * @Route("/secteurs/{id}", name="secteur_get", methods={"GET"})
     */
    public function getOneSecteur(Secteur $secteur): Response
    {
        return $this->json($secteur);
    }

    /**
     * @Route("/secteurs/", name="secteurs_post", methods="POST")
     */
    public function post(CommuneRepository $repo, Request $req, EntityManagerInterface $em): Response
    {
        $faker = Factory::create('fr_FR');
        $secteur = new Secteur();

        $data = json_decode($req->getContent());
        if ($data) {
            $commune = $repo->find($data->commune->id);

            $secteur->setCommunes($commune);
            $secteur->setLatitude($faker->latitude);
            $secteur->setLongitude($faker->longitude);
            $secteur->setNom($data->nom);
            $secteur->setAdresse($data->adresse);
        }
        if ($secteur->getNom() && $secteur->getAdresse() && $secteur->getCommunes()) {

            $em->persist($secteur);
            $em->flush();
            return $this->json($secteur);
        }
        return $this->redirectToRoute('main_home');
    }

}
