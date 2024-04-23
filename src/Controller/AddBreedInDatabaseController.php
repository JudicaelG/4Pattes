<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Breed; 

class AddBreedInDatabaseController extends AbstractController
{
    #[Route('/add/breed/in/database', name: 'app_add_breed_in_database')]
    public function index(EntityManagerInterface $manager): Response
    {
        function fetchDogBreeds($url) {
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
                foreach ($jsonData['data'] as $breedData) {
                    $breedNames[] = $breedData['attributes']['name'];
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
        $startUrl = "https://dogapi.dog/api/v2/breeds";

        // Appel de la fonction pour récupérer les noms des races de chiens
        $allBreeds = fetchDogBreeds($startUrl);

        // Écriture des noms des races de chiens dans le fichier, un nom par ligne
        foreach ($allBreeds as $breedName) {
            $breed = new Breed();
            $breed->setName($breedName);
            $manager->persist($breed);
        }

        $manager->flush();

        return new Response("Ok");
    }
}
