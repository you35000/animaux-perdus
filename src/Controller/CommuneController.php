<?php

namespace App\Controller;

use App\Repository\CommuneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommuneController extends AbstractController
{
    /**
     * @Route ("/declaration/ajax-codepostal", name="declaration_get_communes")
     */
    public function getCommunes(Request $request, CommuneRepository $communeRepository): Response
    {

        $data = json_decode($request->getContent());

        if(trim($data->codepostal) != ''){
            $communes = $communeRepository->findBy(['codepostal' => $data->codepostal]);
        }else{
            $communes = $communeRepository->findAll();
        }

        return $this->json($communes, 200, [], ["groups" => "commune"]);
    }
}
