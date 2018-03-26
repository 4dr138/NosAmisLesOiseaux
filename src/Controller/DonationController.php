<?php

namespace App\Controller;

use App\Service\StripeGift;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DonationController extends AbstractController
{
	/**
    * @Route("/donation/", name="donation")
    */
    public function donation()
    {

        return $this->render('donation/donation.html.twig', array(
                
                'description' => "faire un don",
                "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                ));
    }

    /**
    * @Route("/donation/gift", name="gift")
    */
    public function gift(Request $request, StripeGift $StripeGift)
    {
        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];
        $amount = $_POST['data-amount'];

        try {
            
            $StripeGift->chargeVisa($token, $email, $amount);
            
            return $this->render('donation/sucess.html.twig');
        } catch(\Stripe\Error\Card $e) {

            $this->addFlash("chargeFailed","Oups, le paiement a echoué !!! Veuillez recommencer.");
            return $this->render('donation/donation.html.twig', array(
                'description' => "faire un don",
                "publishable_key" => "pk_test_22Upp5xyncxXUx9EfBE54yEn"
                ));
        }

    }
}