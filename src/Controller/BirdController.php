<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Tests\Fixtures\ToString;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BirdController extends Controller
{

    /**
     * @Route("/getBirds", name="getBirds", options={"expose"=true})
     */
    public function getBirds()
    {
        $em = $this->getDoctrine()->getManager();
        $birds = $em->getRepository('App:Bird')->getBirds();

        return new Response(json_encode($birds));
    }

    /**
     * @Route("/getBirdsByName", name="getBirdsByName", options={"expose"=true})
     */
    public function getBirdsByName()
    {
        $em = $this->getDoctrine()->getManager();
        $birds = $em->getRepository('App:Bird')->getBirdsByName();

        return new Response(json_encode($birds));
    }

    /**
     * @Route("/getBirdIdObs/{id}", name="getBirdIdObs")
     */
    public function getBirdIdObs($id, SessionInterface $session)
    {
        $user = $session->get('users');

        if(isset($user)){
            $em = $this->getDoctrine()->getManager();
            $bird = $em->getRepository('App:Bird')->getBirdIdObs($id);

        return $this->render('observations/birdInformations.html.twig', array('bird' => $bird, 'users' => $user));

        }

        return $this->render('connexion/connexion.html.twig');
    }

}