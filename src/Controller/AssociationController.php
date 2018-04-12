<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AssociationController extends Controller
{

    /**
     * @Route("/association", name="association")
     */
    public function associationAction()
    {
        return $this->render('association/association.html.twig');
    }
}