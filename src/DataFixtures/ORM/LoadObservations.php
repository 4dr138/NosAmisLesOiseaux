<?php

namespace App\DataFixtures\ORM;


use App\Entity\Comments;
use App\Entity\Observation;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class LoadObservations implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $listObs = array('Observation 1');
        foreach ($listObs as $observation) {
            // On crée l'utilisateur
            $obs = new Observation();
            // Le nom d'utilisateur et le mot de passe sont identiques
            $obs->setLatitude(1);
            $obs->setLongitude(1);
            $obs->setComment('Observation 1');
            $obs->setBird(1);
            $obs->setUser(14);

            $obs->setDateObservation(new \DateTime());

            $manager->persist($obs);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }
}