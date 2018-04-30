<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ObservationsService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getObservationsById($userId)
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('App:Observation')->getObsById($userId);

        return $observations;
    }

}