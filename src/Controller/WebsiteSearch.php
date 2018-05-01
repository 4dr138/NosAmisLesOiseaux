<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/users")
 */
class WebsiteSearch extends Controller
{
    /**
     * @Route("/search", name="searchWord", methods="POST")
     */
    public function searchWordAction()
    {
        $word = $_POST['word'];
        $articles = $this->container->get('appbundle.articlesservice')->getArticlesByWord($word);
        $birds = $this->container->get('appbundle.birds')->getBirdsByWord($word);

        return $this->render('search/search.html.twig', array('articles' => $articles, 'word' => $word, 'birds' => $birds));
    }
}
