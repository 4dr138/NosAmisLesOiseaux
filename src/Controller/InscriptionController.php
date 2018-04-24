<?php


namespace App\Controller;

use App\Entity\Users;
use App\Service\CodeGodFatherService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class InscriptionController extends Controller
{

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscriptionAction(Request $request, CodeGodFatherService $CodeGodFatherService, SessionInterface $session)
    {
        $user = new Users();
        $form = $this->createForm("App\Form\UsersType", $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On check l'existence du mail dans la base
           
            $mailExistant = $this->container->get('appbundle.forgotmail')->checkMail($user->getMail());


            if($mailExistant == false) {
                $em = $this->getDoctrine()->getManager();

                
                $user->setRoles(['ROLE_AMATEUR']);
                $user->setGodfatherCode($CodeGodFatherService->generateCode());

                
                $em->persist($user);
                $session->set('users',$user);
                
                
                $em->flush();

                //            $this->container->get('appbundle.mailservice')->sendConfirmationMail($user);

                $this->addFlash("success", "Votre inscription a bien été prise en compte, vous allez recevoir un mail de confirmation !");
                return $this->redirectToRoute('connexion');
            }
            else{
                $this->addFlash("error", "Vous avez déjà un compte chez nous, veuillez vous identifier directement");
                return $this->redirectToRoute('inscription');
            }
        }

        return $this->render('inscription/inscription.html.twig',array('form' => $form->createView()));
    }

}