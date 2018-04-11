<?php

namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CommentsService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getCommentsById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('App:Comments')->getCommentsById($id);

        return $comments;
    }
}