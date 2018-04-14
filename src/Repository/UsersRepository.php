<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function getUserInfo($username, $password)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT u.username, u.password, u.roles 
            FROM App\Entity\Users u 
            WHERE u.username = :username and u.password = :password')
            ->setParameter('username', $username)
            ->setParameter('password', $password);

        return $query->execute();
    }
}
