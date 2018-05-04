<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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

    public function checkObservation($newObs){

        $dateObs = $newObs->getDateObservation();
        $today = new \DateTime();
        // On compare la date saisie avec la date du jour pour s'assurer que la date n'est pas supérieure à la date d'ajd
        if($dateObs >= $today)
            {
                return 'errorDate';
            }
        // On check qu'on ait bien un nombre numérique avant insertion dans la BDD
        else if(is_numeric($newObs->getLatitude()) == false or is_numeric($newObs->getLongitude()) == false)
            {
                return 'errorFloat';
            }
        else
            {
                return 'success';
            }
    }

    public function getUnvalidateObs()
    {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('App:Observation')->getUnvalidateObs();

        return $observations;
    }

    public function updateBirdID($birdID, $id){
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('App:Observation')->updateBirdID($birdID, $id);
    }

    public function deleteObsById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('App:Observation')->deleteObsById($id);
    }

}