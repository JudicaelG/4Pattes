<?php

namespace App\DataFixtures;

use App\Entity\Breed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CatBreedFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Fonction pour récupérer les noms des races de chiens à partir d'une URL
        function fetchCatBreeds($url) {
            $breedNames = array();

            // Boucle pour parcourir toutes les pages
            while ($url !== null) {
                // Récupération des données depuis l'URL
                $data = file_get_contents($url);

                // Vérification si la récupération des données a réussi
                if ($data === false) {
                    echo "Erreur lors de la récupération des données depuis l'API.";
                    exit;
                }

                // Conversion des données JSON en tableau associatif
                $jsonData = json_decode($data, true);

                // Vérification si la conversion JSON a réussi
                if ($jsonData === null) {
                    echo "Erreur lors de la conversion des données JSON.";
                    exit;
                }

                // Extraction des noms des races de chiens de la page actuelle
                foreach ($jsonData as $breedData) {
                    $breedNames[] = $breedData['name'];
                }

                // Récupération de l'URL de la page suivante
                if(isset($jsonData['links']['next'])){
                    $url = $jsonData['links']['next'];                    
                }else{
                    $url=null;
                }
                
            }

            return $breedNames;
        }

        $filePath = __DIR__ . '/catBreed.json';

        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            die('Le fichier ' . $filePath . ' est introuvable.');
        }

        $jsonData = file_get_contents($filePath);

        // Vérifier si le fichier a été lu correctement
        if ($jsonData === false) {
            die('Erreur de lecture du fichier data.json');
        }

        // Décoder le JSON en tableau associatif
        $data = json_decode($jsonData, true);

        // Vérifier si le JSON a été correctement décodé
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die('Erreur de décodage JSON : ' . json_last_error_msg());
        }

        // Vérifier si Dataset_1 existe
        if (!isset($data['Dataset_1'])) {
            die('Dataset_1 est manquant dans les données JSON');
        }

        // Lire et afficher chaque ligne de Dataset_1
        foreach ($data['Dataset_1'] as $row) {
            $breed = new Breed();
            $breed->setName($row['Race']);
            $breed->setType("cat");
            $manager->persist($breed);
        }

        /*// URL de départ
        $startUrl = "https://api.thecatapi.com/v1/breeds";

        // Appel de la fonction pour récupérer les noms des races de chiens
        $allBreeds = fetchCatBreeds($startUrl);

        // Écriture des noms des races de chiens dans le fichier, un nom par ligne
        foreach ($allBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setType("cat");
            $manager->persist($breed);
        }*/

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
