<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Tests\Fixtures\ToString;

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

}