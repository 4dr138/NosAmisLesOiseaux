<?php

namespace App\Repository;

use App\Entity\Bird;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bird|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bird|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bird[]    findAll()
 * @method Bird[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BirdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bird::class);
    }

    public function getBirdById($birdId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT o.dateObservation, o.latitude, o.longitude, o.comment,
            b.taxrefClass, b.taxrefCdName, b.taxrefVern, b.taxrefUrlImage, b.protected,b.id,
            bf.label as family, bs.label as status
            FROM App\Entity\Observation o , App\Entity\Bird b, App\Entity\BirdFamily bf, App\Entity\BirdStatus bs 
            WHERE b.id = o.bird AND b.birdFamily = bf.id AND b.birdStatus = bs.id AND o.bird = :birdId ')
            ->setParameter('birdId', $birdId);
        return $query->execute();
    }

    public function getBirdId($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT o.dateObservation, o.latitude, o.longitude, o.comment,
            b.taxrefClass, b.taxrefCdName, b.taxrefVern, b.taxrefUrlImage, b.protected,b.id,
            bf.label as family, bs.label as status
            FROM App\Entity\Observation o , App\Entity\Bird b, App\Entity\BirdFamily bf, App\Entity\BirdStatus bs 
            WHERE b.id = o.bird AND b.birdFamily = bf.id AND b.birdStatus = bs.id AND b.id = :birdId
            ')
            ->setParameter('birdId', $id);
        return $query->execute();
    }

    public function getBirdsWithWord($word)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT o.dateObservation, o.latitude, o.longitude, o.comment,
        b.taxrefClass,  b.taxrefVern, b.taxrefCdName,
        bf.label as family, bs.label as status, b.id
        FROM App\Entity\Observation o, App\Entity\Bird b, App\Entity\BirdFamily bf, App\Entity\BirdStatus bs 
        WHERE b.id = o.bird AND b.birdFamily = bf.id AND b.birdStatus = bs.id 
        AND o.comment like :word OR b.taxrefClass like :word OR b.taxrefVern like :word OR bf.label like :word OR bs.label like :word
        ORDER BY b.id desc
        ')
            ->setParameter('word', '%' .$word. '%');

        return $query->execute();
    }
//    /**
//     * @return Bird[] Returns an array of Bird objects
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
    public function findOneBySomeField($value): ?Bird
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
