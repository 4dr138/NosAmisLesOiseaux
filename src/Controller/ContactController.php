<?php

namespace App\Controller;

use App\Service\Mail;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{

    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request, Mail $Mail, SessionInterface $session)
    {
        $user = $session->get('users');
        if ($_SERVER['REQUEST_METHOD']=='POST') {

            $nom  = $request->get('name');
            $email  = $request->get('email');
            $message  = $request->get('message');
            

            // On vérifie qu'on ait bien un format email et un format texte
            $check = $Mail->checkInfosContact($nom, $email);
           

            if($check == "errorString" or $check == "errorMail")
            {
                $this->addFlash("error", "Attention, il y a une erreur dans votre saisie du formulaire (format du mail ou format du nom et prénom)");
                return $this->render('contact/contact.html.twig', array('users' => $user));

            }
            else {
                
                $Mail->sendContactMail($nom, $email, $message);

                $this->addFlash("success", "Votre mail a bien été envoyé !");
                return $this->render('contact/contact.html.twig', array('users' => $user));
            }
        }
        return $this->render('contact/contact.html.twig', array('users' => $user));
    }
}