<?php

namespace App\Controller;


use App\Entity\Animal;
use App\Entity\Declaration;
use App\Entity\Etat;
use App\Form\AnimalFormType;
use App\Form\DeclarationFormType;
use App\Repository\AnimalRepository;
use App\Repository\DeclarationRepository;
use App\Repository\EspeceAnimalRepository;
use App\Repository\RaceRepository;
use App\Repository\SecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/internal", name = "app_annonce")
 */

class AnnonceController extends AbstractController

{
    /**
     * Renvoie une chaîne JSON avec les races de l'espèce animal avec l'identifiant fourni.
     *
     * @param Request $request
     * @return JsonResponse
     *
     *
     */
    public function listRacesAnimalAction(Request $request)
    {
        // Get Entity manager and repository
        $em = $this->getDoctrine()->getManager();
        $racesRepository = $em->getRepository("AppBundle:Race");

        // Recherche les races qui appartiennent à l'espèce animal' avec l'id donné comme paramètre GET "especeAnimalid"
        $races = $racesRepository->createQueryBuilder("q")
            ->where("q.especeAnimal = :especeAnimalid")
            ->setParameter("especeAnimalid", $request->query->get("especeAnimalid"))
            ->getQuery()
            ->getResult();

        // Sérialiser dans un tableau les données dont nous avons besoin, dans ce cas uniquement le nom et l'identifiant
        // Remarque: vous pouvez également utiliser un sérialiseur, à des fins d'explication, nous le ferons manuellement
        $responseArray = array();

        foreach($races as $race){
            $responseArray[] = array(
                "id" => $race->getId(),
                "nom" => $race->getNom()
            );
        }
        // Renvoie un tableau avec la structure des races de l'identifiant de l'espèce animal fourni
        return new JsonResponse($responseArray);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/declaration-etape2", name="_step_tow", methods={"GET", "POST"})
     */
    public function newAnimal(Request $request, AnimalRepository $animalRepository): Response
    {
        $animal = new Animal();
        $form = $this->createForm(AnimalFormType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $animalRepository->add($animal);
            return $this->redirectToRoute('app_animal_index');
        }

        $currentUrl = $this->generateUrl('app_annonce_ajax_races');

        return $this->renderForm('annonce/newAnimal.html.twig', [
            'animal' => $animal,
            'form' => $form,
            'currentUrl' => $currentUrl,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/ajax/races", name="_ajax_races", methods={"POST"})
     */
    public function ajaxGetRaces(
        Request $request,
        AnimalRepository $animalRepository,
        RaceRepository $raceRepository,
        EspeceAnimalRepository $especeAnimalRepository
    ): JsonResponse
    {
        $datas = json_decode($request->getContent(), true);

        $getEspeces = $especeAnimalRepository->findOneBy(['id' => $datas["id"]]);

        if ($getEspeces == null) {
            return new JsonResponse(["error" => "Aucune race ne correspond à cette espèce"]);
        }

        $races = $getEspeces->getRaces();
        $rep = [];
        $index = 0;
        foreach ($races as $race) {
            $rep[$index] = [
                "id" => $race->getId(),
                "nom" => $race->getNom(),
            ];

            $index++;
        }

        return new JsonResponse($rep);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/declaration-etape1", name="_step_one", methods={"GET", "POST"})
     */
//    public function newDeclaration(Request $request, DeclarationRepository $declarationRepository): Response
//    {
//        $declaration = new Declaration();
//        $form = $this->createForm(DeclarationFormType::class, $declaration);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $declarationRepository->add($declaration, true);
//
//            return $this->redirectToRoute('main_home', [], Response::HTTP_SEE_OTHER);
//        }
//
//        return $this->renderForm('annonce/test.html.twig', [
//            'declaration' => $declaration,
//            'form' => $form,
//        ]);
//    }
    public function new(Request $req, EntityManagerInterface $em, SecteurRepository $repo): Response
    {

        $form = $this->createForm(DeclarationFormType::class);
        $form->handleRequest($req);


        if ($form->isSubmitted() && $form->isValid()) {
            $newDeclaration = $form->getData();
            $newDeclaration->setSecteur($repo->find($req->request->get('outing_form')['place']));
            $newDeclaration->setOrganizer($this->getUser());

            if ($req->request->get('creer')) {
                $newDeclaration->setEtat($em->getRepository(Etat::class)->findOneBy(['libelle' => 'Créée']));
                $this->addFlash('success', 'Votre sortie ' . $newDeclaration->getName() . ' a bien été créée');
            } elseif ($req->request->get('published')) {
                $newDeclaration->setState($em->getRepository(State::class)->findOneBy(['libelle' => 'Ouverte']));
                $this->addFlash('success', 'Votre sortie ' . $newDeclaration->getName() . ' a bien été publiée');
            };
            $newDeclaration->addAttendee($this->getUser());

            $em->persist($newDeclaration);
            $em->flush();
            return $this->redirectToRoute('app_outing');
        }

        return $this->render('outing/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}