<?php

namespace App\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class LoadArticles implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $listArticles = array('Article 1', 'Article 2', 'Article 3','Article 4','Article 5','Article 6','Article 7');
        foreach ($listArticles as $article) {
            // On crée l'utilisateur
            $art = new Article();
            // Le nom d'utilisateur et le mot de passe sont identiques
            $art->setTitle($article);
            $art->setContent($article);

            $manager->persist($art);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }
}