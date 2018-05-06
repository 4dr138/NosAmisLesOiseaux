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
        $user = $session->get('users');
        return $this->render('donation/donation.html.twig', array(
                
                'users' =>$user,
                'description' => "faire un don",
                "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                ));
    }

    /**
    * @Route("/donation/gift", name="gift")
    */
    public function gift(Request $request, StripeGift $StripeGift, Mail $Mail,SessionInterface $session, ExperienceService $ExperienceService)
    {

        $amount = $request->get('data-amount');
        $name = $request->get('name');
        $firstname = $request->get('firstname');
        $email  = $request->get('stripeEmail');
        
        $user = $session->get('users');
        

        try {
            if(isset($user)){
                $ExperienceService->ExpDonation($user);
            }
            
            
            $StripeGift->chargeVisa($request);
            $Mail->sendDonationMail($email, $amount, $name, $firstname);
            
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