<?php

namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ArticlesService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getArticles()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('App:Article')->getArticles();

        return $articles;
    }

    public function getArticleById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('App:Article')->getArticleById($id);

        return $article;
    }

    public function getarticleID($id)
    {
        $em = $this->getDoctrine()->getManager();
        $articleID = $em->getRepository('App:Article')->getArticleId($id);

        return $articleID;
    }
}