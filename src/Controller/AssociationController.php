<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AssociationController extends Controller
{

    /**
     * @Route("/association", name="association")
     */
    public function associationAction(SessionInterface $session)
    {
        $user = $session->get('users');
        return $this->render('association/association.html.twig', array('users' => $user));
    }
}