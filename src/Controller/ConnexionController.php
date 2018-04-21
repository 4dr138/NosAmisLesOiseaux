<?php

namespace App\Controller;


use App\Entity\Users;
use App\Service\ExperienceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConnexionController extends Controller
{

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction(SessionInterface $session)
    {
        if(isset($_SESSION['username']))
        {
            //$user = $this->container->get('appbundle.checkconnexion')->checkUser($_SESSION['username'], $_SESSION['password']);
            
            $user = $session->get('users');
            //$username = $user[0]['username'];
            /*$newExp = $user->setExperience($user->getExperience() + 5);*/
            $username = $user->getUsername();
            //$role = $user[0]['roles'];
            //$role = $role[0];
            
            $role = $user->getRoles();
            

            if ($role = 'ROLE_AMATEUR') {
                return $this->render('panelcontrol/panelcontrolamateur.html.twig', array('username' => $username));
                
            }
        }
        else {
            
            return $this->render('connexion/connexion.html.twig');
        }
    }

    /**
     * @Route("/checkUser", name = "checkUser")
     *
     */
    public function checkUserAction(SessionInterface $session, ExperienceService $ExperienceService)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = htmlentities($_POST['username']);
            $password = htmlentities($_POST['password']);
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $username;

            $user = $this->container->get('appbundle.checkconnexion')->checkUser($username, $password);
            
            if ($user == false) {
                $this->addFlash('error', "Les informations d'authentification sont erronées, veuillez ré-essayer.");
                return $this->render('connexion/connexion.html.twig', array('message' => $this));
            } else {
                $username = $user->getUsername();
                
                $role = $user->getRoles();
             
                $ExperienceService->ExpConnexion($user);
                $session->set('users',$user);

                if ($role = 'ROLE_AMATEUR') {
                    return $this->render('panelcontrol/panelcontrolamateur.html.twig', array('username' => $username, 'users' => $user));
                }
            }


        }
    }

    /**
     * @Route("/forgotpass", name = "forgotpass")
     *
     */
    public function forgotPassAction()
    {
        return $this->render('connexion/forgotpassword.html.twig');
    }

    /**
     * @Route("/mailPass", name = "mailPass")
     *
     */
    public function mailPassAction()
    {
        $mail = htmlentities($_POST['mail']);

        $email = $this->container->get('appbundle.forgotmail')->checkMail($mail);
        if($email == false)
        {
            $this->addFlash('error', "Attention, votre mail n'existe pas, veuillez ré-essayer !");
            return $this->redirectToRoute('forgotpass');
        }
        else {
            $randompassword = $this->container->get('appbundle.forgotmail')->randomPassword($email);

            // Variables concernant l'email

            $destinataire = $email;
            $sujet = 'Réinitialisation de votre mot de passe - Nos Amis Les Oiseaux '; // Titre de l'email
            $contenu = '<html><head><title>Réinitialisation du mot de passe</title></head><body>';
            $contenu .= '<p>Bonjour, ci-dessous votre nouveau mot de passe à utiliser pour vous connecter à votre espace.</p>';
            $contenu .= '<p><strong>Nouveau mot de passe : </strong>: ' . $randompassword . '</p>';
            $contenu .= '<p>A bientôt sur notre site !</p>';
            $contenu .= '</body></html>';

            // Pour envoyer un email HTML, l'en-tête Content-type doit être défini
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

            //            mail($destinataire, $sujet, $contenu, $headers);
            $this->addFlash("success", "Un mail contenant votre nouveau mot de passe vient de vous être envoyé ! ");
            return $this->redirectToRoute('forgotpass');
        }
    }

}