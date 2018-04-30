<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ObservationController extends Controller
{

    /**
     * @Route("/observation", name="observation")
     */
    public function observationAction(SessionInterface $session)
    {
        $user = $session->get('users');
        $userId = $user->getId();

//        On récupère les observations selon l'id de l''user
        $observations = $this->container->get('appbundle.observations')->getObservationsById($userId);

//        On récupère ensuite un array des oiseaux associés à une ou plusieurs obs pour un même user
        $birds = $this->container->get('appbundle.birds')->getBirdsByObs($observations);

        return $this->render('observations/user_observation.html.twig', array('birds' => $birds));

    }

    /**
     * @Route("/bird/{id}", name="birdInfos")
     */
    public function birdInformations($id)
    {
        $bird = $this->container->get('appbundle.birds')->getBirdById($id);

        return $this->render('observations/birdInformations.html.twig', array('bird' => $bird));
    }
}