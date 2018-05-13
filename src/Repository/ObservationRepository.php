<?php

namespace App\Repository;

use App\Entity\Observation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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

    public function getUserIdByObs($id)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o.user')
            ->where('o.id =' .$id);
            
        return $qb->getQuery()->getSingleScalarResult();
    }


    public function deleteAllObservations()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'DELETE FROM App\Entity\Observation');

        $query->execute();
    }

    public function getUnvalidateObs()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT o.dateObservation, o.longitude, o.latitude, o.comment, o.id, b.taxrefCdName, o.image
        FROM App\Entity\Observation o, App\Entity\Bird b
        WHERE b.taxrefVern = o.birdName
        AND o.bird = 0
        ');

        return $query->execute();
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

    public function getObservationsForMap($birdID = null)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o.bird', 'o.latitude', 'o.longitude')
            ->leftJoin('App:Bird', 'b', 'WITH', 'o.bird = b.id')
            ->addSelect('b.protected', 'b.taxrefVern');

        $bird = $this->getEntityManager()->getRepository('App:Bird')->findOneBy(['id' => $birdID,]);
        if (null !== $bird) {
            $qb
                ->where('o.bird = :birdID' )
                ->setParameter('birdID', $birdID);
        }

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getObservationsWithFamilyForMap($birdFamilyId = 0)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o.bird', 'o.latitude', 'o.longitude')
            ->leftJoin('App:Bird', 'b', 'WITH', 'o.bird = b.id')
            ->addSelect('b.protected', 'b.taxrefVern');

        if (0 !== intval($birdFamilyId)) {
            $qb
                ->where('b.birdFamily = :birdFamilyId' )
                ->setParameter('birdFamilyId', $birdFamilyId);
        }

        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
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
