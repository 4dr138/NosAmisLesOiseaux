<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getArticles()
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.title, a.content, a.id, a.image')
            ->orderBy('a.id', 'DESC');
        return $qb->getQuery()->execute();
    }

    public function getArticleById($id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.title, a.content, a.id')
            ->where('a.id =' .$id);
        return $qb->getQuery()->execute();
    }

    public function getLastArticleId()
    {

        $qb = $this->createQueryBuilder('a');
        
        $qb
            ->select('MAX(a.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getArticleId($id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.title, a.content, a.id')
            ->where('a.id =' .$id);

        return $qb->getQuery()->execute();
    }

    public function deleteArticleId($id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->delete()
            ->where('a.id=' .$id);
        $qb->getQuery()->execute();
    }

    public function updateArticleId($id, $title, $content)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'UPDATE App\Entity\Article a
            SET a.title = :title, a.content = :content 
            WHERE a.id = :id')
            ->setParameter('title', $title)
            ->setParameter('content', $content)
            ->setParameter('id', $id);

        $query->execute();
    }

    public function getArticlesByWord($word)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("
        SELECT a.title, a.content, a.id
        FROM App\Entity\Article a
        WHERE a.title like :word OR a.content like :word ORDER BY a.id desc")
            ->setParameter('word', '%' . $word . '%');

       return $query->execute();
    }
}
