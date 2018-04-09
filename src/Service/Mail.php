<?php 
 namespace App\Service; 
  
 use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
 use Twig\Environment; 
  
  
 class Mail 
 { 
     //const EMAIL = 'newsletter@ceorangeso.com'; 
     const EMAIL = 'contact@projet4.yuqi.fr';
     private $twig; 
     private $mailer; 
  
     public function __construct(Environment $twig, \Swift_Mailer $mailer) 
     { 
         $this->twig = $twig; 
         $this->mailer =$mailer; 
     } 
   
  
     public function sendMail($email, $amount, $name, $firstname) 
     { 
         
         
         $message = (new \Swift_Message('Certificat de donation.')) 
             ->setFrom(self::EMAIL) 
             ->setTo($email) 
             ->setBody( 
                 $this->twig->render('donation/sucess.html.twig', array('amount'=> $amount, 'name'=> $name, 'firstname'=> $firstname)), 
                 'text/html' 
             ); 
         $this->mailer->send($message); 
     }


    /* public function sendMail($name, $firstname, $email, $amount)
    {
            $destinataire = 'contact@nos-amis-les-oiseaux.fr';
            $sujet = 'Contact'; // Titre de l'email
            $contenu = '<html><head><title>Certificat de donation</title></head><body>';
            $contenu .= '<p>Bonjour, vous avez reçu un message à partir de votre site web.</p>';
            $contenu .= '<p><strong>Nom</strong>: '.$nom.'</p>';
            $contenu .= '<p><strong>Email</strong>: '.$email.'</p>';
            $contenu .= '<p><strong>Prénom</strong>: '.$message.'</p>';
            $contenu .= '</body></html>';

            // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
            $headers = 'MIME-Version: 1.0'."\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

            // On utilise SwiftMailer pour envoyer le mail
            $this->get('mailer')->send($message);
    }*/
 
 } 
