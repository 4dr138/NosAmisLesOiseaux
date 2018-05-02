<?php

namespace App\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Users;

class LoadUser implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = array('Alexandre', 'Marine', 'Anna');
        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new Users;
            // Le nom d'utilisateur et le mot de passe sont identiques
            $user->setUsername($name);
            $user->setPassword($name);
            $user->setName($name);
            $user->setFirstname($name);
            $user->setmail($name);
            $user->setGodfatherCode('');
            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(['ROLE_ADMIN']);
            // On le persiste
            $manager->persist($user);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }
}