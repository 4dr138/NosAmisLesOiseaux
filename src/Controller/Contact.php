<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class Contact extends Controller
{

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            $nom     = htmlentities($_POST['nom']);
            $email   = htmlentities($_POST['email']);
            $message = htmlentities($_POST['message']);

            // Variables concernant l'email

            $destinataire = 'contact@nos-amis-les-oiseaux.fr';
            $sujet = 'Contact'; // Titre de l'email
            $contenu = '<html><head><title>Titre du message</title></head><body>';
            $contenu .= '<p>Bonjour, vous avez reçu un message à partir de votre site web.</p>';
            $contenu .= '<p><strong>Nom</strong>: '.$nom.'</p>';
            $contenu .= '<p><strong>Email</strong>: '.$email.'</p>';
            $contenu .= '<p><strong>Message</strong>: '.$message.'</p>';
            $contenu .= '</body></html>';

            // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

//            mail($destinataire, $sujet, $contenu, $headers);
        $this->addFlash("success", "Votre mail a bien été envoyé !");
        }
        return $this->render('contact/contact.html.twig');
    }
}