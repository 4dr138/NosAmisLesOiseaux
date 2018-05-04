<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            $nom     = htmlentities($_POST['name']);
            $email   = htmlentities($_POST['email']);
            $message = htmlentities($_POST['message']);

            // On vérifie qu'on ait bien un format email et un format texte
            $check = $this->container->get('appbundle.mailservice')->checkInfosContact($nom, $email);

            if($check == "errorString" or $check == "errorMail")
            {
                $this->addFlash("error", "Attention, il y a une erreur dans votre saisie du formulaire (format du mail ou format du nom et prénom)");
                return $this->render('contact/contact.html.twig');

            }
            else {
                $this->container->get('appbundle.mailservice')->sendContactMail($nom, $email, $message);

                $this->addFlash("success", "Votre mail a bien été envoyé !");
                return $this->render('contact/contact.html.twig');
            }
        }
        return $this->render('contact/contact.html.twig');
    }
}