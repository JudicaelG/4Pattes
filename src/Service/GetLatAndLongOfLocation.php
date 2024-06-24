<?php

namespace App\Service;

class GetLatAndLongOfLocation{
    public function __construct(String $nameOfCity){
        $this->locationInformations = $this->GetLatAndLong($nameOfCity);
    }

    private $locationInformations;
    
    private function GetLatAndLong(String $nameOfCity){
        // URL de l'API
        $url = "https://geocode.maps.co/search?q=" . $nameOfCity . "&api_key=66795dffe2230999327237pif414bca";

        // Initialiser une session cURL
        $ch = curl_init();

        // Configurer les options cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Exécuter la requête cURL
        $response = curl_exec($ch);

        // Vérifier les erreurs cURL
        if(curl_errno($ch)) {
            echo 'Erreur cURL : ' . curl_error($ch);
        } else {
            // Décoder la réponse JSON en tableau associatif
            return $response;
        }

        // Fermer la session cURL
        curl_close($ch);
    }

    public function GetLat(){
        $data = json_decode($this->locationInformations, true);

        // Vérifier si le JSON a été correctement décodé
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die('Erreur de décodage JSON : ' . json_last_error_msg());
        }

        // Accéder à la propriété 'lat' du premier (et seul) élément du tableau
        $lat = $data[0]['lat'];

        return $lat;
    }

    public function GetLong(){
        $data = json_decode($this->locationInformations, true);

        // Vérifier si le JSON a été correctement décodé
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die('Erreur de décodage JSON : ' . json_last_error_msg());
        }

        // Accéder à la propriété 'lat' du premier (et seul) élément du tableau
        $long = $data[0]['lon'];

        return $long;
    }
}