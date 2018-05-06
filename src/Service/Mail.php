<?php 
 namespace App\Service; 
  
 use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface; 
 use Twig\Environment; 
  
  
 class Mail 
 { 
     //const EMAIL = 'newsletter@ceorangeso.com'; 
     const EMAIL = 'contact@billetteriemuseedulouvre.fr';
     private $twig; 
     private $mailer; 
  
     public function __construct(Environment $twig, \Swift_Mailer $mailer) 
     { 
         $this->twig = $twig; 
         $this->mailer =$mailer; 
     } 
   
  
     public function sendDonationMail($email, $amount, $name, $firstname) 
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

     public function sendRandomPassword($randompassword, $email)
    {
        $message = (new \Swift_Message('Votre mot de passe temporaire.')) 
             ->setFrom(self::EMAIL) 
             ->setTo($email) 
             ->setBody( 
                 $this->twig->render('connexion/mailRandomPass.html.twig', [ 
                     'randompassword'=>$randompassword 
                 ]), 
                 'text/html' 
             ); 
         $this->mailer->send($message);
    }

    public function sendContactMail($nom, $email, $message)
    {
        // Variables concernant l'email

        $message = (new \Swift_Message('Nouveau message de contact reçu.')) 
             ->setFrom(self::EMAIL) 
             ->setTo('contact@nos-amis-les-oiseaux.fr') 
             ->setBody( 
                 $this->twig->render('contact/mailMessageContact.html.twig', [ 
                     'nom'=>$nom, 'email'=>$email, 'message'=>$message
                 ]), 
                 'text/html' 
             ); 
         $this->mailer->send($message);

    }

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
            ->setFrom(self::EMAIL)
            ->setTo($email)
            ->setBody(
                $this->renderView('inscription/mailconfirmation.html.twig', array('name' => $name, 'firstname' => $firstname, 'username' => $username, 'newsletter' => $newsletter)),
                'text/html'
            );
        // On utilise SwiftMailer pour envoyer le mail
        $this->mailer->send($message);
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
