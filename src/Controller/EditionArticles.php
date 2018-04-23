<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditionArticles extends Controller
{

    /**
     * @Route("/panelListingArticles", name="panelListingArticles")
     */
    public function actualitesAction()
    {
        $articles = $this->container->get('appbundle.articlesservice')->getArticles();

        return $this->render('panelcontrol/panelListingArticles', array('articles' => $articles));
    }

    /**
     * @Route("/deleteArticle/{id}", name="deleteArticle")
     */
    public function deleteArticleAction($id)
    {
        $this->container->get('appbundle.articlesservice')->deleteArticleId($id);

        return $this->redirectToRoute('panelListingArticles');
    }

    /**
     * @Route("/editArticle/{id}", name="editArticle")
     */
    public function editArticleAction($id, Request $request)
    {
        $article = $this->container->get('appbundle.articlesservice')->getArticleById($id);
        $comments = $this->container->get('appbundle.commentsservice')->getCommentsById($id);

        foreach ($article[0] as $values) {
            $id = $values;
        }

        if(isset($_POST['content']))
        {
            $content = $_POST['content'];
            $title = $_POST['title'];
            $this->container->get('appbundle.articlesservice')->updateArticleId($id,$title, $content);

            return $this->redirectToRoute('panelListingArticles');
        }

        return $this->render('panelcontrol/panelEditArticles', array('article' => $article, 'comments' => $comments));
    }
}