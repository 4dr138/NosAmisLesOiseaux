<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ForgotMail extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function checkMail($mail)
    {
        $em = $this->getDoctrine()->getManager();
        $usermail = $em->getRepository('App:Users')->getMail($mail);
        if(empty($usermail))
        {
            return false;
        }
        else{
            foreach($usermail[0] as $value)
            {
                $mail = $value;
            }
            return $mail;
        }
    }

    public function randomPassword($email)
    {
        // On génère ensuite notre chaine aléatoire
        $characts    = 'abcdefghijklmnopqrstuvwxyz';
        $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts   .= '1234567890';
        $code_aleatoire      = '';
        for($i=0;$i < 10;$i++)    //10 est le nombre de caractères
        {
            $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1);
        }
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('App:Users')->updateMail($email, $code_aleatoire);

        return $code_aleatoire;
    }
}