<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MailService extends Controller
{
    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * Envoie le mail de confirmation
     *
     */
    public function sendConfirmationMail($user)
    {
       foreach($user as $mail)
       {
           $name = $user->getName();
           $firstname = $user->getFirstName();
           $username = $user->getUserName();
           $email = $user->getMail();
           $newsletter = $user->getNewsletter();

       }
        // On commence par configurer l'envoi de mail de confirmation
        $message = (new \Swift_Message('Recapitulatif de commande'))
            ->setFrom('contact@billetteriemuseedulouvre.fr')
            ->setTo($email)
            ->setBody(
                $this->renderView('inscription/mailconfirmation.html.twig', array('name' => $name, 'firstname' => $firstname, 'username' => $username, 'newsletter' => $newsletter)),
                'text/html'
            );
        // On utilise SwiftMailer pour envoyer le mail
        $this->get('mailer')->send($message);
    }

    public function sendContactMail($nom, $email, $message)
    {
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
    }

    public function checkInfosContact($nom, $email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL) == false)
        {
            return 'errorMail';
        }
        else if(filter_var($nom, FILTER_VALIDATE_FLOAT) !== false)
        {
            return 'errorString';
        }
        else
        {
            return 'checkOk';
        }
    }


}