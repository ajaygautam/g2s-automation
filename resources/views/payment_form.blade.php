
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Payment Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

        <style>
            .form-wrap{
                display: flex;
            }
            #payment-form{
                border: 1px solid #eee;
                padding: 30px 20px;
                border-radius: 10px;
                width: 500px;
                background: #f9f9f9;
            }
            .StripeElement {
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
            }

        </style>
    </head>
    <body>
        <div class="form-wrap d-flex justify-content-center align-items-center">
            <form action="{{url('/stripe_subscription')}}" method="post" id="payment-form">
            @csrf
            <input type="hidden" name="plan_code" value="{{$plan->plan_code}}" />
            
                <h3 class="text-center mb-2">Payment Info</h3>
                    <div class="form-group">
                        <label>Name</label>
                        <input name="customer_name" placeholder="Enter Full Name" type="text" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input name="primary_email" placeholder="Enter your email address" type="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Membership Plan</label>
                        <span class="form-control">{{$plan->plan_name}}</span>
                    </div>
                    <div class="form-group">
                        <label>Credit card Info</label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        
                        <div id="card-errors" class="text-danger" role="alert"></div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">I agree with terms and conditions</label>
                    </div>
        
                <button class="btn btn-primary mt-3">Submit Payment</button>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            $(document).ready(function(){
                $(".form-wrap").height($(window).height());
            });
            // Create a Stripe client.
            var stripe = Stripe('pk_test_JA0U3awxLyRc5Cu4a8vbujfa00sFbI8J1R');

            // Create an instance of Elements.
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                    color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {style: style});

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
            });

            // Handle form submission.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createToken(card).then(function(result) {
                if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
                } else {
                // Send the token to your server.
                stripeTokenHandler(result.token);
                }
            });
            });

            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
            }

        </script>


    </body>
</html>