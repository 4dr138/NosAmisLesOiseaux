<?php
namespace App\Service;

use Stripe\Stripe;

class StripeGift
{

  public function chargeVisa($token, $email, $totalOrder)
  {
    \Stripe\Stripe::setApiKey("sk_test_PHraORksdzZk8MWcZPkv9gA5");


          $customer = \Stripe\Customer::create(array(
              'email' => $email,
              'source'  => $token
          ));

          $charge = \Stripe\Charge::create(array(
              'customer' => $customer->id,
              'amount'   => $totalOrder*100,
              'currency' => 'eur'
          ));
          
  }
}