<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\Comments1Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class BlogController extends Controller
{
    /**
     * @Route("/blog/{id}", name="blog")
     */
    public function blogAction($id, Request $request, SessionInterface $session)
    {
        // On récupère les articles et les commentaires associés à cet article via l'id de l'article
        $article = $this->container->get('appbundle.articlesservice')->getArticleById($id);
        $comments = $this->container->get('appbundle.commentsservice')->getCommentsById($id);
        $user = $session->get('Users');
        
        // On boucle sur le tableau récupéré pour récupérer l'index 0 et l'injecter directement dans la vue
        foreach($article[0] as $values)
            {
                $id = $values;
            }
        $newcomment = new Comments();

        $form = $this->createForm(Comments1Type::class, $newcomment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newcomment->setArticleID($id);
            $newcomment->setDatecomment(new \DateTime());
            // On récupère le pseudo de l'auteur, soit en dur, soit en session
            if(isset($_SESSION['username'])){
                $newcomment->setAuthor($_SESSION['username']);
            }

            $em->persist($newcomment);
            $em->flush();

            return $this->redirectToRoute('blog', array('id' => $id));
        }

        return $this->render('blog/blog.html.twig', array('article' => $article, 'comments' => $comments, 'form' => $form->createView()));
    }

    /**
     *
     * @Route("/checkID/{id}", name="checkID", options={"expose"=true})
     */
    public function checkID($id)
    {
        $articleID = $this->container->get('appbundle.articlesservice')->getarticleID($id);
        if(!empty($articleID)) {
            foreach ($articleID[0] as $values) {
                $articleID = $values;
            }
        }
        else{
            $articleID = -99;
        }
        return new Response($articleID);
    }

}