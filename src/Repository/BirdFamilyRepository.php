<?php

namespace App\Repository;

use App\Entity\BirdFamily;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

/**
 * @method BirdFamily|null find($id, $lockMode = null, $lockVersion = null)
 * @method BirdFamily|null findOneBy(array $criteria, array $orderBy = null)
 * @method BirdFamily[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BirdFamilyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BirdFamily::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('label' => 'ASC'));
    }

    public function getFamiliesObserved()
    {
        $qb = $this->createQueryBuilder('f');
        $qb
            ->leftJoin('App:Bird', 'b', 'WITH', 'b.birdFamily = f.id')
            ->join('App:Observation', 'o', 'WITH', 'o.bird = b.id')
            ->where('o.bird <> 0')
            ->groupBy('f')
            ->orderBy('f.label');

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);

    }
//    /**
//     * @return BirdFamily[] Returns an array of BirdFamily objects
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
    public function findOneBySomeField($value): ?BirdFamily
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
