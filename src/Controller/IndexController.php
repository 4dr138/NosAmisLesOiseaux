<?php
/**
 * Created by PhpStorm.
 * User: adrien.gautier
 * Date: 28/03/2018
 * Time: 16:38
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//        session_destroy();
        if(!isset($_SESSION))
        {
            session_start();
        }
        return $this->render('homepage/homepage.html.twig');
    }


    /**
     * @Route("/mentions", name="mentions")
     */
    public function showMention()
    {
        return $this->render('footer/mentions.html.twig');
    }

}