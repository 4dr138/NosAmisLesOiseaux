<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConnexionService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function checkUser($username, $password)
    {
        //$em = $this->getDoctrine()->getManager();
        //$userInfos = $em->getRepository('App:Users')->getUserInfo($username, $password);
        $em = $this->getDoctrine()->getManager();
        $userInfos = $em->getRepository('App:Users')->findOneBy(['username' => $username, 'password' => $password ]);
        if(!empty($userInfos))
        {
            dump($userInfos);
            return $userInfos;
        }
        else
        {
            return false;
        }
    }
}