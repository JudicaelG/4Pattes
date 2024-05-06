<?php

namespace App\Repository;

use App\Entity\Animals;
use App\Service\AddVaccinated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Form;

/**
 * @extends ServiceEntityRepository<Animals>
 *
 * @method Animals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animals[]    findAll()
 * @method Animals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Animals::class, $entityManager);
    }

    public function saveAnimal(Animals $animal, $entityManager, $vaccines, $dateVaccine, $addVaccinated): Response{
        
        if($animal->getId()){
            $editAnimal = $entityManager->getRepository(Animals::class)->find($animal->getId());
            if(!$editAnimal){
                throw $this->createNotFoundException(
                    'Pas d\'animal avec cette identifiant'
                );
            }

            $editAnimal->setName($animal->getName());
            $editAnimal->SetBirthday($animal->getBirthday());
            $editAnimal->SetWeight($animal->getWeight());
            $editAnimal->SetBreedId($animal->getBreedId());
            $editAnimal->SetUserId($animal->getUserId());
            $entityManager->flush();

            return new Response('Your animal has been modified !');
        }

        $newAnimal = new Animals();
        $newAnimal->setName($animal->getName());
        $newAnimal->SetBirthday($animal->getBirthday());
        $newAnimal->SetWeight($animal->getWeight());
        $newAnimal->SetBreedId($animal->getBreedId());
        $newAnimal->SetUserId($animal->getUserId());
        $newAnimal->setProfilePhoto($animal->getProfilePhoto());
        $newAnimal = $addVaccinated->AddVaccine($vaccines, $dateVaccine, $animal);   

        $entityManager->persist($newAnimal);

        $entityManager->flush();

        return new Response('Your animal has been added !');
    }

    public function deleteAnimal($id, $entityManager){       

    }

    public function getConnectedUserAnimals($userId){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a, b
            FROM App\Entity\Animals a
            INNER JOIN a.breed_id b
            WHERE a.user_id = :userId
            ORDER BY a.id DESC'
        )->setParameter('userId', $userId);

        return $query->getResult();
    }

    public function getAnimalWithVaccineAndVaccineDate($id){
        return $this->createQueryBuilder('a')
        ->andWhere('a.id = :id') 
        ->setParameter('id', $id)
        ->leftJoin('a.vaccinateds', 'v')
        ->addSelect('v')
        ->getQuery()
        ->getOneOrNullResult();
    }
    
//    /**
//     * @return Animals[] Returns an array of Animals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Animals
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
