<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PanelControl extends Controller
{

    /**
     * @Route("/panelControl", name = "panelControl")
     */
    public function panelControlAction($user)
    {
        dump($user);exit;
        return $this->render('panelcontrol/panelcontrol.html.twig');
    }
}