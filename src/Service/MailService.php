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


}