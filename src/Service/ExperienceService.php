<?php

namespace App\Service;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExperienceService extends Controller
{
    const DONATION_XP = 300;

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

    public function ExpDonation(Users $user)
    {
        
        $em = $this->getDoctrine()->getManager();
               
                    $user->setExperience($user->getExperience() + self::DONATION_XP);
                    $em->merge($user);
                    $em->flush();

    }

    public function doLevelAward(Users $user)
    {
        $userXp = $user->getExperience();
        switch ($userXp) {
            case ($userXp<51):
                return 'un Moineau';
                break;
            case ($userXp<101):
                return 'un Rouge gorge';
                break;
            case ($userXp<251):
                return 'un Pivert';
                break;
            case ($userXp<501):
                return 'un Merle';
                break;
            case ($userXp<751):
                return 'un Corbeau';
                break;
            case ($userXp<1251):
                return 'une hirondelle';
                break;
            case ($userXp<2501):
                return 'une Colombe';
                break;
            case ($userXp<5001):
                return 'une Mouette';
                break;
            case ($userXp<7501):
                return 'un Cygne';
                break;
            case ($userXp<10001):
                return 'un Vautour';
                break;
            case ($userXp<15000):
                return 'un Aigle';
                break;
            case ($userXp>14999):
                return 'un Aigle Royal';
                break;
        }
    }
}