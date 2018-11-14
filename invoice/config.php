<?php
require_once('vendor/autoload.php');

$stripe = array(
  "secret_key"      => "sk_test_QAOB4zNVtNPYNa4NU5TvyS3c",
  "publishable_key" => "pk_test_emf3DSSLiFAB3x0dhSPxRABN"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>