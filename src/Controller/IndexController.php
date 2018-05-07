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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class IndexController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(SessionInterface $session, Request $request)
    {

        $user = $session->get('users');

        $birdId = $request->get('birdId');
        dump($birdId);

        return $this->render('homepage/homepage.html.twig', array('users' => $user));
    }


    /**
     * @Route("/mentions", name="mentions")
     */
    public function showMention()
    {
        return $this->render('footer/mentions.html.twig');
    }

    /**
     * @Route("/test", name="mentions")
     */
    public function testAction()
    {
        return $this->render('test/test.html.twig');
    }

}