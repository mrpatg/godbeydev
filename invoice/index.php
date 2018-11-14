<?php
session_start();
if($_SESSION['error']){
    $message = '<div class="alert alert-danger" role="alert"><strong>Error</strong>'.$_SESSION_['error'].'</div>';
    unset($_SESSION['error']);
}
if($_SESSION['success']){
    $message = '<div class="alert alert-success" role="alert"><strong>Payment Complete</strong>'.$_SESSION_['success'].'</div>';
    unset($_SESSION['success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Godbey Development - Invoicing</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/main.css">
    <style>
    body{
        background-color: #f8f9fa!important;
    }
        /* Blue outline on focus */
        .StripeElement--focus {
            border-color: #80BDFF;
            outline:0;
            box-shadow: 0 0 0 .2rem rgba(0,123,255,.25);
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        /* Can't see what I type without this */
        #card-number.form-control,
        #card-cvc.form-control,
        #card-exp.form-control {
            display:inline-block;
        }
        #errorMessageContainer{
          display:none;
        }
        .block-heading{
            padding-top: 50px;
            margin-bottom: 40px;
            text-align: center;
        }
        form{
            border-top: 2px solid #00BC8A;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.075);
            background-color: #ffffff;
            padding: 0;
            max-width: 600px;
            margin: auto;
        }
        .footer{
            max-width: 600px;
            margin: auto;
            padding-bottom:30px;
            text-align:center:
        }
        .info,
        .card-details{
            padding: 40px;
        }
        form label{
            font-size: 0.8em;
            color: #00BC8A;
        }
        a,
        a:hover,
        a:active,
        a:focus{
            color: #00BC8A;
        }

        input[type="submit"], input[type="reset"], input[type="button"], button, .button {
            background-color: #fafafa;
            color: #efefef !important;
        }
    </style>
</head>
<body>
<section id="banner">
				<div class="inner split">
					<section>
						<h2>Godbey Development</h2>
						<h3>Applied Software Development and Consulting</h3>
					</section>
					<section>
						<p>
                            Invoice Payment Portal
                        </p>
                        <p></p>
						<ul class="actions">
							<li><a href="https://godbeydevelopment.com" class="button special">Back to main site</a></li>
						</ul>
					</section>
				</div>
			</section>
    <div class="container">
        <div class="block-heading">
          <p></p>
          <p><img  class="mx-auto d-block" src="ccicons.png"></p>
        </div>
        <div id="card-errors" role="alert">
        </div>
                <form id="payment-form" action="./charge.php" method="POST" class="needs-validation" novalidate>
                    <div class="info">
                        <h5 class="title">Invoice Information</h5>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Payment Amount</label>
                                
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="text" class="form-control" id="amount" value="<?php echo $_GET['p']; ?>" required>
                                    <div class="invalid-feedback">
                                    Please enter an amount.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">                            
                                <label for="name">Description</label>
                                <div class="input-group mb-2">
                                    <textarea class="form-control" id="description"><?php echo base64_decode($_GET['desc']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h5 class="title">Contact Information</h5>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Email Address</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="email">
                                </div>
                                <label for="name">Name</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <label for="name">Address</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="address">
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                
                                <label for="name">City</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="city">
                                </div>
                                <label for="name">State</label>
                                <div class="input-group mb-2">
                                <select class="form-control" id="state" name="state">
                                    <option value="">State</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DC">District of Columbia</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="IA">Iowa</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MD">Maryland</option>
                                    <option value="ME">Maine</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MT">Montana</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NY">New York</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VA">Virginia</option>
                                    <option value="VT">Vermont</option>
                                    <option value="WA">Washington</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                                </div>
                                <label for="name">Zip</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="zip">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-details">
                        <h5 class="title">Credit Card Details</h5>
                        <div class="row">
                            <div class="form-group col-sm-7">
                                <label for="card-holder">Name of Card Holder</label>
                                <input id="card-holder" type="text" class="form-control" aria-label="Name of Card Holder" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="">Expiration Date (MM/YY)</label>
                                <span id="card-exp" class="form-control">
                                    <!-- Stripe Card Expiry Element -->
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-8">
                                <label for="card-number">Card Number</label>
                                <span id="card-number" class="form-control">
                                    <!-- Stripe Card Element -->
                                </span>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="cvc">3 Digit CVC</label>
                                <span id="card-cvc" class="form-control">
                                    <!-- Stripe CVC Element -->
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <div id="total"></div>
                            </div>
                            <div class="form-group col-sm-12">
                                <button id="payment-submit" class="btn btn-success mt-1" disabled><i class="fas fa-lock"></i> Submit Payment</button>
                            </div>
                        </div>

                    <div class="alert alert-danger" role="alert" id="errorMessageContainer">
                      
                    </div>

                </form>
    </div>
    <div class="footer text-center">
    <small class="text-muted" class="mx-auto d-block text-center" ><a href="https://godbeydevelopment.com">Godbey Development</a> <br> Contact via email contact@godbeydev.com or call us at 304-207-0101.</small>
    </div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://js.stripe.com/v3/"></script>
<script src="../invoice/jquery.number.min.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">


<script>
    $(document).ready(function(){
        
        var $price_check = $('#amount' ).val();

            if( $price_check.length === 0 ) {
                // empty value
                $('#payment-submit').prop('disabled', true);
            }else{
                $('#total').text('Total: $' + $price_check);
                $('#payment-submit').prop('disabled', false);
            }

        var $input = $('#amount' );

        $input.number( true, 2 );

        $input.on( "keyup", function( event ) {
            // When user select text in the document, also abort.
            var selection = window.getSelection().toString();
            if ( selection !== '' ) {
                return;
            }            
            // When the arrow keys are pressed, abort.
            if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
                return;
            } 
            var $this = $( this );
            var input = $this.val();
            $this.val(input);
            if( input.length === 0 ) {
                
            }else{
                $('#total').text('Total: $' + $input.val());
                $('#payment-submit').prop('disabled', false);
            }
            
        } );
        // Create a Stripe client
        var stripe = Stripe('pk_test_0xBMN6DRRYCw2nJHn2GPcQWt');

        // Create an instance of Elements
        var elements = stripe.elements();

        // Try to match bootstrap 4 styling
        var style = {
            base: {
                'lineHeight': '1.35',
                'fontSize': '1.11rem',
                'color': '#495057',
                'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
            }
        };

        // Card number
        var card = elements.create('cardNumber', {
            'placeholder': '',
            'style': style
        });
        card.mount('#card-number');

        // CVC
        var cvc = elements.create('cardCvc', {
            'placeholder': '',
            'style': style
        });
        cvc.mount('#card-cvc');

        // Card expiry
        var exp = elements.create('cardExpiry', {
            'placeholder': '',
            'style': style
        });
        exp.mount('#card-exp');

        // Submit
        $('#payment-submit').on('click', function(e){
          $("#errorMessageContainer").hide();

            e.preventDefault();
            var cardData = {
                'name': $('#name').val()
            };
            stripe.createToken(card, cardData).then(function(result) {
                console.log(result);
                if(result.error && result.error.message){
                    $("#errorMessageContainer").html(result.error.message);
                    $("#errorMessageContainer").show();

                }else{
                  stripeTokenHandler(result.token);
                }
            });
        });

    });
    function stripeTokenHandler(token) {
                    // Insert the token ID into the form so it gets submitted to the server
                    var form = document.getElementById('payment-form');
                    var hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripeToken');
                    hiddenInput.setAttribute('value', token.id);
                    var hiddenInputName = document.createElement('input');
                    hiddenInputName.setAttribute('type', 'hidden');
                    hiddenInputName.setAttribute('name', 'name');
                    hiddenInputName.setAttribute('value', $('#name').val());
                    var hiddenInputAmount = document.createElement('input');
                    hiddenInputAmount.setAttribute('type', 'hidden');
                    hiddenInputAmount.setAttribute('name', 'amount');
                    hiddenInputAmount.setAttribute('value', $('#amount').val());
                    var hiddenInputEmail = document.createElement('input');
                    hiddenInputEmail.setAttribute('type', 'hidden');
                    hiddenInputEmail.setAttribute('name', 'email');
                    hiddenInputEmail.setAttribute('value', $('#email').val());
                    var hiddenInputDescription = document.createElement('input');
                    hiddenInputDescription.setAttribute('type', 'hidden');
                    hiddenInputDescription.setAttribute('name', 'description');
                    hiddenInputDescription.setAttribute('value', $('#description').val());
                    var hiddenInputCity = document.createElement('input');
                    hiddenInputCity.setAttribute('type', 'hidden');
                    hiddenInputCity.setAttribute('name', 'city');
                    hiddenInputCity.setAttribute('value', $('#city').val());
                    var hiddenInputZip = document.createElement('input');
                    hiddenInputZip.setAttribute('type', 'hidden');
                    hiddenInputZip.setAttribute('name', 'zip');
                    hiddenInputZip.setAttribute('value', $('#zip').val());
                    var hiddenInputAddress = document.createElement('input');
                    hiddenInputAddress.setAttribute('type', 'hidden');
                    hiddenInputAddress.setAttribute('name', 'address');
                    hiddenInputAddress.setAttribute('value', $('#address').val());
                    var hiddenInputState = document.createElement('input');
                    hiddenInputState.setAttribute('type', 'hidden');
                    hiddenInputState.setAttribute('name', 'state');
                    hiddenInputState.setAttribute('value', $('#state').val());
                    var hiddenInputInvoice = document.createElement('input');
                    hiddenInputInvoice.setAttribute('type', 'hidden');
                    hiddenInputInvoice.setAttribute('name', 'invoice');
                    hiddenInputInvoice.setAttribute('value', $('#invoice').val());

                    form.appendChild(hiddenInput);
                    form.appendChild(hiddenInputName);
                    form.appendChild(hiddenInputEmail);
                    form.appendChild(hiddenInputAmount);
                    form.appendChild(hiddenInputDescription);
                    form.appendChild(hiddenInputAddress);
                    form.appendChild(hiddenInputCity);
                    form.appendChild(hiddenInputState);
                    form.appendChild(hiddenInputZip);
                    form.appendChild(hiddenInputInvoice);

                    // Submit the form
                    form.submit();
                  } 
</script>
</body>
</html>