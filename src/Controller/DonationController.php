<?php

namespace App\Controller;

use App\Service\StripeGift;
use App\Service\Mail;
use App\Service\ExperienceService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DonationController extends AbstractController
{
	/**
    * @Route("/donation/", name="donation")
    */
    public function donation(SessionInterface $session)
    {
        
        return $this->render('donation/donation.html.twig', array(
                
                
                'description' => "faire un don",
                "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                ));
    }

    /**
    * @Route("/donation/gift", name="gift")
    */
    public function gift(Request $request, StripeGift $StripeGift, Mail $Mail,SessionInterface $session, ExperienceService $ExperienceService)
    {

        $token  = $request->get('stripeToken');
        $email  = $request->get('stripeEmail');
        $amount = $request->get('data-amount');
        $name = $request->get('name');
        $firstname = $request->get('firstname');
        
        $user = $session->get('users');
        dump($user);

        try {
            if(isset($user)){
                $ExperienceService->ExpDonation($user);
            }
            
            $StripeGift->chargeVisa($token, $email, $amount);
            $Mail->sendMail($email, $amount, $name, $firstname);
            
            return $this->render('donation/sucess.html.twig', array('amount'=> $amount, 'name'=> $name, 'firstname'=> $firstname, 'users' =>$user));
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("chargeFailed","Oups, le paiement a echoué !!! Veuillez recommencer.");
            return $this->render('donation/donation.html.twig', array(
                'description' => "faire un don",
                "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                ));
        }

    }
}