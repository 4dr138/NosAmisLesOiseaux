<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\ArticlesService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ActualitesController extends Controller
{

    /**
     * @Route("/actualites", name="actualites")
     */
    public function actualitesAction(SessionInterface $session, ArticlesService $ArticlesService)
    {
    	$user = $session->get('users');
//        Récupération de la liste d'articles avant injection dans la vue
        $articles = $ArticlesService->getArticles();

        return $this->render('actualites/actualites.html.twig', array('articles' => $articles, 'users' => $user));
    }
}