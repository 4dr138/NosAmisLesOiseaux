<?php

namespace App\Service;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BirdService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getBirdsByObs($obs, $userId)
    {
        $em = $this->getDoctrine()->getManager();
        $birds = [];
        for($i = 0; $i < count($obs); $i++) {
            $birdId = $obs[$i]->getBird();
            $observations = $em->getRepository('App:Bird')->getBirdByIdObs($birdId, $userId);

            $birds[$i] = $observations;
        }
        return $birds;
    }

    public function getBirdById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bird = $em->getRepository('App:Bird')->getBirdId($id);

        return $bird;
    }

    public function getBirdsByWord($word)
    {
        $em = $this->getDoctrine()->getManager();
        $birds = $em->getRepository('App:Bird')->getBirdsWithWord($word);

        return $birds;
    }

    public function getExistingBird($taxrefCdName)
    {
        $em = $this->getDoctrine()->getManager();
        $bird = $em->getRepository('App:Bird')->getExistingBird($taxrefCdName);

        return $bird;
    }

}