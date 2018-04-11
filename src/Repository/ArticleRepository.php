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
            ->select('a.title, a.content, a.id')
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

    public function getArticleId($id)
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->select('a.title, a.content, a.id')
            ->where('a.id =' .$id);

        return $qb->getQuery()->execute();
    }
}
