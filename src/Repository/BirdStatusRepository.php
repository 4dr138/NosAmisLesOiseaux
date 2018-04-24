<?php

namespace App\Repository;

use App\Entity\BirdStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BirdStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method BirdStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method BirdStatus[]    findAll()
 * @method BirdStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BirdStatusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BirdStatus::class);
    }

//    /**
//     * @return BirdStatus[] Returns an array of BirdStatus objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BirdStatus
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
