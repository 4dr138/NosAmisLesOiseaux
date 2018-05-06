<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    public function getCommentsById($id)
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT c.author, c.content, c.datecomment, c.id, c.articleID
            FROM App\Entity\Comments c
            WHERE c.articleID = :id
            ORDER BY c.id desc')
            ->setParameter('id', $id);

        return $query->execute();
    }

    public function deleteAllComments()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'DELETE FROM App\Entity\Comments');

        $query->execute();
    }

    public function signalComment($id)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'UPDATE App\Entity\Comments c
            SET c.signalement = TRUE
            WHERE c.id = :id')
        ->setParameter('id', $id);

        $query->execute();
    }
}
