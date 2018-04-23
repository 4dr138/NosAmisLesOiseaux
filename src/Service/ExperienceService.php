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

    public function ExpParrainage($godfatherCode)
    {
        
        $em = $this->getDoctrine()->getManager();
        $userParrain = $em->getRepository('App:Users')->findOneBy(['godfatherCode' =>$godfatherCode]);
        
            if(isset($userParrain)){
                
                    
                    $userParrain->setExperience($userParrain->getExperience() + 25);

                    $em->persist($userParrain);
                    $em->flush();

        }
        


    }
}