<?php

namespace App\Service;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExperienceService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function ExpConnexion(Users $user)
    {
        $em = $this->getDoctrine()->getManager();
        $newExp = $user->setExperience($user->getExperience() + 5);
        $em->persist($user);
        $em->flush();

    }

    public function ExpInscription($godfatherCode)
    {
        $em = $this->getDoctrine()->getManager();
        $userParrain = $em->getRepository('App:Users')->findOneBy(['godfatherCode' =>$godfatherCode]);
/*        $newExp = $userParrain->setExperience($userParrain->getExperience() + 5);
        $em->persist($userParrain);
        $em->flush();*/

    }
}