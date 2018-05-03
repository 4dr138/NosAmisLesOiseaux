<?php

namespace App\DataFixtures\ORM;


use App\Entity\Comments;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class LoadComments implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager
            ->getRepository(Comments::class)
            ->deleteAllComments();

        $listComments = array('Auteur');
        foreach ($listComments as $comment) {
            // On crée l'utilisateur
            $commentaire = new Comments();
            // Le nom d'utilisateur et le mot de passe sont identiques
            $commentaire->setAuthor($comment);
            $commentaire->setContent($comment);
            $commentaire->setDatecomment(new \DateTime());
            $commentaire->setArticleID(77);

            $manager->persist($commentaire);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }
}