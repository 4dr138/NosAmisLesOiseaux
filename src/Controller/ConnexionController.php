<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConnexionController extends Controller
{

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction()
    {
        return $this->render('connexion/connexion.html.twig');
    }

    /**
     * @Route("/checkUser", name = "checkUser")
     *
     */
    public function checkUserAction()
    {
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);

            $user = $this->container->get('appbundle.checkconnexion')->checkUser($username, $password);

            if($user == false)
            {
                $this->addFlash('error', "Les informations d'authentification sont erronées, veuillez ré-essayer.");
                return $this->render('connexion/connexion.html.twig', array('message' => $this));
            }
            else
            {
                foreach($user[0] as $value)
                {
                }
                dump($value);exit;

                return $this->redirectToRoute('panelControl', array('user' => $user));
            }


        }
    }
}