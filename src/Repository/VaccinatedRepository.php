<?php

namespace App\Repository;

use App\Entity\Vaccinated;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vaccinated>
 *
 * @method Vaccinated|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vaccinated|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vaccinated[]    findAll()
 * @method Vaccinated[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VaccinatedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vaccinated::class);
    }

//    /**
//     * @return Vaccinated[] Returns an array of Vaccinated objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vaccinated
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
