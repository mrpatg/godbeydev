<?php
require_once('vendor/autoload.php');

$stripe = array(
  "secret_key"      => "sk_live_6tNxJWooLiV66njgsLATdvwZ",
  "publishable_key" => "pk_live_Z0SEwJuktLs0eLERxeYGoJnb"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>