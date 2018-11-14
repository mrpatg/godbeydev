<?php
session_start();
require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_QAOB4zNVtNPYNa4NU5TvyS3c');
$token = $_POST['stripeToken'];
// Convert amount to dollars
$total = htmlspecialchars($_POST['amount']);
$amount = htmlspecialchars($_POST['amount'] * 100);
if(!is_numeric($amount)){
    $_SESSION['error'] = 'There was a problem processing your request.';
    header("Location: index.php");
}
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$address = htmlspecialchars($_POST['address']);
$city = htmlspecialchars($_POST['city']);
$state = htmlspecialchars($_POST['state']);
$zip = htmlspecialchars($_POST['zip']);
$invoice = htmlspecialchars($_POST['invoice']);
$description = htmlspecialchars($_POST['description']);
try{
    $charge = \Stripe\Charge::create(
        array(
            'amount' => $amount,
            'currency' => 'usd',
            'source' => $token,
            'description' => $description,
            'metadata' => array(
                'email' => $email,
                'name' => $name,
                'address' => $address,
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'invoice' => $invoice,

            ),
            'receipt_email' => $email,

        )
    );
    $success = 1;
} catch(Stripe_CardError $e) {
    $error1 = $e->getMessage();
  } catch (Stripe_InvalidRequestError $e) {
    // Invalid parameters were supplied to Stripe's API
    $error2 = $e->getMessage();
  } catch (Stripe_AuthenticationError $e) {
    // Authentication with Stripe's API failed
    $error3 = $e->getMessage();
  } catch (Stripe_ApiConnectionError $e) {
    // Network communication with Stripe failed
    $error4 = $e->getMessage();
  } catch (Stripe_Error $e) {
    // Display a very generic error to the user, and maybe send
    // yourself an email
    $error5 = $e->getMessage();
  } catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe

    $error6 = $e->getMessage();
  }
  
  if ($success!=1)
  {
      $_SESSION['error'] = $error1;
      $_SESSION['error'] = $error2;
      $_SESSION['error'] = $error3;
      $_SESSION['error'] = $error4;
      $_SESSION['error'] = $error5;
      $_SESSION['error'] = $error6;
      header('Location: index.php');
      exit();
  }
$_SESSION['success'] = 'Payment of $'.$total.' for invoice# '.$invoice.' has been made.<br> You will recieve an email reciept shortly.';
header("Location: index.php");
exit();
?>