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

        // URL de départ
        $startUrl = "https://api.thecatapi.com/v1/breeds";

        // Appel de la fonction pour récupérer les noms des races de chiens
        $allBreeds = fetchCatBreeds($startUrl);

        // Écriture des noms des races de chiens dans le fichier, un nom par ligne
        foreach ($allBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $breed->setType("cat");
            $manager->persist($breed);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group2'];
    }
}
