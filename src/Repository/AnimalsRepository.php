<?php

namespace App\Repository;

use App\Entity\Animals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;

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

    public function saveAnimal(Animals $animal, $entityManager): Response{
        
        $newAnimal = new Animals();
        $newAnimal->setName($animal->getName());
        $newAnimal->SetBirthday($animal->getBirthday());
        $newAnimal->SetBreedId($animal->getBreedId());
        $newAnimal->SetUserId($animal->getUserId());
        
        $entityManager->persist($newAnimal);

        $entityManager->flush();

        return new Response('Your animal has been added !');
    }

    public function getConnectedUserAnimals($userId){
        return $this->createQueryBuilder('a')
        ->andWhere('a.user_id = :userId')
        ->setParameter('userId', $userId)
        ->getQuery()
        ->getResult();
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
