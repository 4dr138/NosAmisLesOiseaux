<?php

namespace App\Controller;

use App\Entity\BirdFamily;
use App\Entity\Newsletter;
use App\Entity\Users;
use App\Form\NewsletterType;
use App\Service\ArticlesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class IndexController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(SessionInterface $session, Request $request, ArticlesService $ArticlesService)
    {
        $user = $session->get('users');

        $newsletter = new Newsletter();
        $LastArticleId = $ArticlesService->getLastArticleId();

        $birds = $this->container->get('appbundle.birds')->getLast10Birds();

        $accessToProtectedBirds = false;
        if (null !== $user) {
            $userRoles = $user->getRoles();
            $nbPoint = $user->getExperience();

            if (in_array('ROLE_ADMIN', $userRoles) || in_array('ROLE_NATURALISTE', $userRoles) || $nbPoint >= 5000) {
                $accessToProtectedBirds = true;
            }
        }

        $birdFamilies = $this->getDoctrine()->getRepository(BirdFamily::class)->getFamiliesObserved();

        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

             $this->addFlash("success", "Merci pour votre inscription à la newsletter !");
            return $this->redirectToRoute('homepage');
        }

        return $this->render('homepage/homepage.html.twig', array(
            'users'                 => $user,
            'newsletter'            => $newsletter,
            'LastArticleId'         => $LastArticleId,
            'accessToProtectedBird' => $accessToProtectedBirds,
            'birdFamilies'          => $birdFamilies,
            'birds'                 => $birds,
            'form'                  => $form->createView())
        );

    }

    /**
     * @Route("/mentions", name="mentions")
     */
    public function showMention()
    {
        return $this->render('footer/mentions.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction()
    {
        return $this->render('test/test.html.twig');
    }

}
