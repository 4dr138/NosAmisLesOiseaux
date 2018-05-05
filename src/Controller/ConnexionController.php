<?php

namespace App\Controller;


use App\Entity\Users;
use App\Service\ExperienceService;
use App\Service\ConnexionService;
use App\Service\ForgotMail;
use App\Service\Mail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConnexionController extends Controller
{

    /**
     * @Route("/connexion", name="connexion")
     */
    public function connexionAction(SessionInterface $session, ExperienceService $ExperienceService)
    {

        $user = $session->get('users');
        if(isset($user)) {

            $role = $user->getRoles();
            $role = $role[0];

            $userLevel = $ExperienceService->doLevelAward($user);
            if ($role == 'ROLE_AMATEUR') {
                return $this->render('panelcontrol/panelcontrolamateur.html.twig', array('users' => $user, 'userLevel' => $userLevel));

            } else if ($role == 'ROLE_NATURALISTE') {
                return $this->render('panelcontrol/panelcontrolnaturaliste.html.twig', array('users' => $user, 'userLevel' => $userLevel));
            }
        }

            return $this->render('connexion/connexion.html.twig');

    }

    /**
     * @Route("/checkUser", name = "checkUser")
     *
     */
    public function checkUserAction(Request $request, SessionInterface $session, ExperienceService $ExperienceService,ConnexionService $ConnexionService)
    {
        if (isset($request)) {
            
            $username  = $request->get('username');
            $password  = $request->get('password');


            // On check les informations d'authentification en fonction du pseudo et du mot de passe associé
            $user = $ConnexionService->checkUser($username, $password);
           
            if ($user == false) {
                $this->addFlash('error', "Les informations d'authentification sont erronées, veuillez ré-essayer.");
                return $this->render('connexion/connexion.html.twig', array('message' => $this));
            } else {

                $username = $user->getUsername();

                $role = $user->getRoles();
                $ExperienceService->ExpConnexion($user);
                $userLevel = $ExperienceService->doLevelAward($user);
                // On update les données de session
                $session->set('users', $user);

                // On récupère le premier index du tableau de role (défini en tant que tableau dans l'entité)
                $role = $role[0];


                if ($role == 'ROLE_AMATEUR') {
                    return $this->render('panelcontrol/panelcontrolamateur.html.twig', array('users' => $user, 'userLevel'=> $userLevel));
                } else if ($role == 'ROLE_NATURALISTE') {
                    return $this->render('panelcontrol/panelcontrolnaturaliste.html.twig', array('users' => $user, 'userLevel'=> $userLevel));
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
    public function mailPassAction(Request $request,ForgotMail $ForgotMail,Mail $Mail)
    {
        
        $mail = $request->get('mail');
        $email = $ForgotMail->checkMail($mail);

        if($email == false)
        {
            $this->addFlash('error', "Attention, votre mail n'existe pas, veuillez ré-essayer !");
            return $this->redirectToRoute('forgotpass');
        }
        else {
            $randompassword = $ForgotMail->randomPassword($email);
            $Mail->sendRandomPassword($randompassword, $email);
            
            //            mail($destinataire, $sujet, $contenu, $headers);
            $this->addFlash("success", "Un mail contenant votre nouveau mot de passe vient de vous être envoyé ! ");
            return $this->redirectToRoute('forgotpass');
        }
    }

    /**
     * @Route("/deconnexionPanel", name = "deconnexionPanel")
     *
     */
    public function deconnexionPanelAction()
    {
        session_destroy();
        return $this->redirectToRoute('homepage');
    }



}