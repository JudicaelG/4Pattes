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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animals::class);
    }

    public function saveAnimal(Animals $animal): Response{
        
        $entityManager = $this->getEntityManager();

        $entityManager->persist($animal);

        $entityManager->flush();

        return new Response('Your animal has been added !');
    }

    public function deleteAnimal($id, $entityManager){       

    }

    public function getConnectedUserAnimals($userId){

        return $this->createQueryBuilder('a')
        ->innerJoin('a.breed_id', 'b')
        ->addSelect('b')
        ->innerJoin('a.vaccinateds', 'v')
        ->addSelect('v')
        ->innerJoin('v.vaccine_id', 'vc')
        ->addSelect('vc')
        ->andWhere('a.user_id = :userId')
        ->orderBy('v.next_recall', 'asc')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();

        /*$entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a, b
            FROM App\Entity\Animals a
            INNER JOIN a.breed_id b
            WHERE a.user_id = :userId
            ORDER BY a.id DESC'
        )->setParameter('userId', $userId);

        return $query->getResult();*/
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

    public function getAnimalWithVaccineAndVaccineDateAndDayBeforeNextRecall($id){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT 
                a, v, vv 
                FROM App\Entity\vaccinated v
            inner join v.vaccine_id vv
            inner join v.animal_id a
            WHERE a.user_id = :userId'
        )->setParameter('userId', $id);

        return $query->getResult();
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
