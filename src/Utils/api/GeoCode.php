<?php


namespace App\Utils\api;

use App\Entity\Commune;

//renseigner votre clé api juste après
const API_KEY = "";
const API_URL = "https://maps.googleapis.com/maps/api/geocode/json?";


class GeoCode
{

    public function callApi(string $adresse, Commune $commune)
    {
        $adresse_encode = urlencode($adresse . " " . $commune->getCodepostal() . " " . $commune->getNom());
        $api_url = API_URL . "adresse=" . $adresse_encode . "&key=" . API_KEY;



        $coord = json_decode(file_get_contents($api_url));

        $latitude = "";
        $longitude = "";
        $adresse = "";
        if ($coord->status == "OK") {
            $latitude = $coord->results[0]->geometry->secteur->lat;
            $longitude = $coord->results[0]->geometry->secteur->lng;
            $adresse = explode(', ', $coord->results[0]->formatted_adresse)[0];
        }

        return ['lat' => $latitude, 'lng' => $longitude, 'adresse' => $adresse];
    }


}