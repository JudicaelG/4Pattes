<?php

namespace App\Repository;

use App\Entity\Ride;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ride>
 *
 * @method Ride|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ride|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ride[]    findAll()
 * @method Ride[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ride::class);
    }

    public function findRideCreatedByTheConnectedUser($idUser): array{

        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $now->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('r')
            ->andWhere('r.user_creator = :idUser')
            ->andWhere('r.date > :datetimeNow')
            ->setParameter('datetimeNow', $now) 
            ->setParameter('idUser', $idUser)
            ->getQuery()
            ->getResult();
    }

    public function findRideWhereTheUserParticipate($idUser): array{
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $now->format('Y-m-d H:i:s');
        
        return $this->createQueryBuilder('r')
        ->leftJoin('r.participants', 'p')
        ->leftjoin('p.user_id', 'u')
        ->addSelect('p')
        ->addSelect('u')
        ->andWhere('u.id = :idUser')
        ->andWhere('r.date > :datetimeNow')
        ->setParameter('datetimeNow', $now) 
        ->setParameter('idUser', $idUser)        
        ->getQuery()
        ->getResult();
    }

    public function findRidesWhereTheUserNotParticipate($idUser): array{

        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $now->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('r')
        ->leftJoin('r.participants', 'p')
        ->leftjoin('p.user_id', 'u')
        ->addSelect('p')
        ->addSelect('u')
        ->andWhere('r.user_creator != :idUser')
        ->andWhere('u.id != :idUser OR u.id IS NULL')
        ->andWhere('r.date > :datetimeNow')
        ->setParameter('idUser', $idUser)
        ->setParameter('datetimeNow', $now)        
        ->getQuery()
        ->getResult();
    }

    public function findAllRideWithCertainDistance($lat, $lon, $setDistance, $actualUser): array
    {
        $now = new DateTime('now', new DateTimeZone('Europe/Paris'));
        $date = $now->format('Y-m-d H:i:s');

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM get_distance_between_location_user_ride_function(:lat, :lon, :actualUser, :dateNow)
            WHERE distance <= :setDistance
            ';

        $resultSet = $conn->executeQuery($sql, ['lat' => $lat, 'lon' => $lon, 'setDistance' => $setDistance, 'actualUser' => $actualUser, 'dateNow' => $date]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    /**
//     * @return Ride[] Returns an array of Ride objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Ride
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
