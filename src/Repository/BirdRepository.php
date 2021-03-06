<?php

namespace App\Repository;

use App\Entity\Bird;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
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
            SELECT o.dateObservation, o.latitude, o.longitude, o.comment, o.image,
            b.taxrefClass, b.taxrefCdName, b.taxrefVern, b.taxrefUrlImage, b.protected,b.id,
            bf.label as family, bs.label as status
            FROM App\Entity\Bird b
            LEFT OUTER JOIN App\Entity\Observation o WITH b.id = o.bird
            LEFT OUTER JOIN App\Entity\BirdFamily bf WITH b.birdFamily = bf.id 
            LEFT OUTER JOIN App\Entity\BirdStatus bs WITH b.birdStatus = bs.id
            WHERE b.id = :birdId
            ')
            ->setParameter('birdId', $id);
        return $query->execute();
    }

    public function getBirdsWithWord($word)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
        SELECT b.taxrefClass,  b.taxrefVern, b.taxrefCdName,b.taxrefUrlImage, b.id
        FROM App\Entity\Bird b
        WHERE b.taxrefVern like :word 
        ORDER BY b.id desc
        ')
            ->setParameter('word', '%' .$word. '%');

        return $query->execute();
    }

    public function getExistingBird($taxrefCdName)
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b.id')
            ->where('b.taxrefCdName = ' .$taxrefCdName);
        $birdExistant = $qb->getQuery()->execute();
        foreach($birdExistant[0] as $value)
        {
            $bird = $value;
        }

        return $bird;

    }

    public function getBirds()
    {
        $qb = $this->createQueryBuilder('b');
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

    public function getBirdsByName()
    {
        $qb = $this->createQueryBuilder('b');
        $qb
            ->select('b.taxrefVern', 'b.id');
        return $qb->getQuery()->execute();
    }

    public function getBirdByIdObs($birdId, $userId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT distinct o.longitude, o.dateObservation, o.latitude,  o.comment,
            b.taxrefClass, b.taxrefCdName, b.taxrefVern, b.taxrefUrlImage, b.protected,o.id,
            bf.label as family, bs.label as status
            FROM App\Entity\Bird b
            JOIN App\Entity\Observation o WITH o.bird = b.id
            JOIN APP\Entity\Users u WITH u.id = o.user
            LEFT OUTER JOIN App\Entity\BirdFamily bf WITH  bf.id = b.birdFamily 
            LEFT OUTER JOIN App\Entity\BirdStatus bs WITH bs.id = b.birdStatus 
            WHERE b.id = :birdId AND o.comment <> '' AND o.user = :userId")
            ->setParameter('birdId', $birdId)
            ->setParameter('userId', $userId);
        return $query->execute();
    }

    public function getLast10Birds()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT o.id, o.image, b.id AS idBird
            FROM App\Entity\Observation o
            LEFT OUTER JOIN App\Entity\Bird b WITH b.id = o.bird
            WHERE o.image <> '' AND o.bird <> 0
            ORDER BY o.id DESC
            ")
            ->setMaxResults(12);

        return $query->execute();
    }

    public function getBirdIdObs($obsId)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            "SELECT distinct o.longitude, o.dateObservation, o.latitude,  o.comment, o.image,
            b.taxrefClass, b.taxrefCdName, b.taxrefVern, b.taxrefUrlImage, b.protected,o.id,
            bf.label as family, bs.label as status
            FROM App\Entity\Bird b
            JOIN App\Entity\Observation o WITH o.bird = b.id
            JOIN APP\Entity\Users u WITH u.id = o.user
            LEFT OUTER JOIN App\Entity\BirdFamily bf WITH  bf.id = b.birdFamily 
            LEFT OUTER JOIN App\Entity\BirdStatus bs WITH bs.id = b.birdStatus 
            WHERE o.id = :obsId")
            ->setParameter('obsId', $obsId);

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
