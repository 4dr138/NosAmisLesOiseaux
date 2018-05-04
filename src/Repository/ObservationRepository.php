<?php

namespace App\Repository;

use App\Entity\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Observation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Observation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Observation[]    findAll()
 * @method Observation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObservationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Observation::class);
    }

    public function getObsById($userId)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o')
            ->where('o.user =' .$userId)
            ->orderBy('o.id', 'DESC');
        return $qb->getQuery()->execute();
    }

    public function getUnvalidateObs()
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o')
            ->where('o.bird = 0')
            ->orderBy('o.id', 'DESC');
        return $qb->getQuery()->execute();
    }

    public function updateBirdID($birdID, $id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        UPDATE App\Entity\Observation o
        SET o.bird = :birdID
        WHERE o.id = :id
        ')
            ->setParameter('birdID', $birdID)
            ->setParameter('id', $id);
        $query->execute();
    }

    public function deleteObsById($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        DELETE FROM App\Entity\Observation o
        WHERE o.id = :id
        ')
            ->setParameter('id', $id);
        $query->execute();
    }


//    /**
//     * @return Observation[] Returns an array of Observation objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Observation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
