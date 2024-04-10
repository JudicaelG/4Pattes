<?php

namespace App\Repository;

use App\Entity\Aniamls;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Aniamls>
 *
 * @method Aniamls|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aniamls|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aniamls[]    findAll()
 * @method Aniamls[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AniamlsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aniamls::class);
    }

//    /**
//     * @return Aniamls[] Returns an array of Aniamls objects
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

//    public function findOneBySomeField($value): ?Aniamls
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
