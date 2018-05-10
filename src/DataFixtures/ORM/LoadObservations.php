<?php

namespace App\DataFixtures\ORM;

use App\Entity\Observation;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LoadObservations implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager
            ->getRepository(Observation::class)
            ->deleteAllObservations();

        $listObs = array(
            [
                'latitude'  => 48.862725,
                'longitude' => 2.287592,
                'comment'   => 'Observation test n°1',
                'birdId'    => 5,
                'userId'    => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Alexandre'])
                    ->getId(),
                'date'      => new \DateTime(),
            ],
            [
                'latitude'  => 47.386330,
                'longitude' => 3.969477 ,
                'comment'   => 'Observation test n°2',
                'birdId'    => 1285,
                'userId'    => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Marine'])
                    ->getId(),
                'date'      => new \DateTime(),
            ],
            [
                'latitude' => 44.676192,
                'longitude' => -0.824683,
                'comment' => 'Observation test n°3',
                'birdId' => 782,
                'userId' => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Anna'])
                    ->getId(),
                'date' => new \DateTime(),
            ],
            [
                'latitude' => 49.557635,
                'longitude' => 3.435177,
                'comment' => 'Observation test n°4',
                'birdId' => 1311,
                'userId' => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Alexandre'])
                    ->getId(),
                'date' => new \DateTime(),
            ],
            [
                'latitude'  => 47.154873,
                'longitude' => 4.128012,
                'comment'   => 'Observation test n°5',
                'birdId'    => 462,
                'userId'    => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Marine'])
                    ->getId(),
                'date'      => new \DateTime(),
            ],
            [
                'latitude' => 47.152713,
                'longitude' => 4.103988,
                'comment' => 'Observation test n°6',
                'birdId' => 952,
                'userId' => $manager
                    ->getRepository('App:Users')
                    ->findOneBy(['username' => 'Anna'])
                    ->getId(),
                'date' => new \DateTime(),
            ],
        );

        foreach ($listObs as $dataObs) {
            // On crée l'utilisateur
            $obs = new Observation();
            // Le nom d'utilisateur et le mot de passe sont identiques
            $obs->setLatitude($dataObs['latitude']);
            $obs->setLongitude($dataObs['longitude']);
            $obs->setComment($dataObs['comment']);
            $obs->setBird($dataObs['birdId']);
            $obs->setUser($dataObs['userId']);
            $obs->setDateObservation($dataObs['date']);

            $manager->persist($obs);
        }
        // On déclenche l'enregistrement
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LoadUser::class,
        );
    }
}