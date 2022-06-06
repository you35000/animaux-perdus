<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Entity\Secteur;
use App\Form\SecteurFormType;
use App\Repository\CommuneRepository;
use App\Utils\api\GeoCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;



class SecteurController extends AbstractController
{
    /**
     * @Route("/lieu/créer", name="secteur_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response   {

        $secteur = new Secteur();
        $secteurForm = $this->createForm(SecteurFormType::class, $secteur,[
        'method' => 'POST',
            //permet d'avoir l'attribut action avec l'url
            'action' => $this->generateUrl('secteur_create')
        ]);

        $secteurForm->handleRequest($request);

        if($secteurForm->isSubmitted() && $secteurForm->isValid()){

            $entityManager->persist($secteur);
            $entityManager->flush();

        }else{
            return $this->render('annonce/Forms/secteurForm.html.twig', [
                'secteurForm' => $secteurForm->createView()
            ]);
        }

        return $this->json($secteur, 200, [], ["groups" => "secteur"]);
    }

    /**
     * @Route ("/declaration/ajax-secteur", name="declaration_get_secteur")
     */
    public function getSecteurWithGeoCode(Request $request, CommuneRepository $communeRepository, GeoCode $geoCode): Response
    {

        $data = json_decode($request->getContent());
        /**
         * @var Commune $commune
         */
        $commune = $communeRepository->find($data->commune);

        $result = $geoCode->callApi($data->adresse, $commune);

        return $this->json($result);
    }

    /**
     * @Route ("/declaration/ajax-secteurs", name="declaration_get_secteurs")
     */
    public function getSecteurByCommune(Request $request, CommuneRepository $communeRepository){

        $data = json_decode($request->getContent());

        $secteurs = $communeRepository->findBy(['commune' => $data->commune]);

        return $this->json($secteurs, 200, [], ['groups' => 'secteur']);

    }

}
