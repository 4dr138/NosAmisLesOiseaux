<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActualitesController extends Controller
{

    /**
     * @Route("/actualites", name="actualites")
     */
    public function actualitesAction()
    {
//        Récupération de la liste d'articles avant injection dans la vue
        $articles = $this->container->get('appbundle.articlesservice')->getArticles();

        return $this->render('actualites/actualites.html.twig', array('articles' => $articles));
    }
}