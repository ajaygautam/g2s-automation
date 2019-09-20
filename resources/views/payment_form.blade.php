<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
        .form-wrap {
            display: flex;
        }

        #payment-form {
            border: 1px solid #eee;
            padding: 20px 20px 30px;
            border-radius: 10px;
            max-width: 500px;
            background: #f9f9f9;
            margin: auto;
            margin-top: 30px;
            width: 100%;
        }

        .StripeElement {
            height: 38px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
            /* box-shadow: 0 1px 3px 0 #e6ebf1; */
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }


        .details-wrap {
            background: #fff;
            border-radius: 4px;
            border: 1px solid #ced4da;
            padding: 15px;
        }
    </style>
</head>

<body>

<div class="form-wrap d-flex justify-content-center align-items-center">
        <form action="{{url('/stripe_subscription')}}" method="post" id="payment-form">
            @csrf
            <input type="hidden" name="plan_code" value="{{$plan->plan_code}}" />

            <div class="top-wrap mb-3">
                <h3 class="text-center mb-0">MEMBERSHIP</h3>
                <h6 class="text-center mb-1">Info and payment details</h6>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input name="customer_name" placeholder="Enter Full Name" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="primary_email" placeholder="Enter your email address" type="email" class="form-control" />
            </div>


            <div class="form-group">
                <label>Address</label>
                <input name="address" placeholder="" type="text" class="form-control" />
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>City</label>
                        <input name="city" placeholder="" type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>State</label>
                        <select name="state" id="state" class="form-control">
                            <option value="">Please select</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option values="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>County</label>
                        <input name="county" placeholder="" type="text" class="form-control" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input name="zipcode" placeholder="" type="text" class="form-control" />
                    </div>
                </div>
            </div>





            <div class="form-group">
                <label>Country</label>
                <select name="country" id="country" class="form-control">
                    <option value="">Please select</option>
                    <option value="USA" selected>US</option>
                </select>
            </div>
            <div class="form-group">
                <label>Membership Plan</label>
                <span class="form-control">{{$plan->plan_name}}</span>
            </div>
            <div class="form-group">
                <label>Payment details</label>
                <div class="details-wrap">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fees</span> <span><strong>${{$plan->cost}}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span> <span><strong>$40</strong></span>
                    </div>
                    <hr class="m-0 mb-1">
                    <div class="d-flex justify-content-between ">
                        <span>Total</span> <span><strong>$890</strong></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Credit card Info</label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <div id="card-errors" class="text-danger" role="alert"></div>
            </div>

            <div class="form-group">
                <label>Referred By</label>
                <select name="referral" id="referral" class="form-control">
                    <option value="">Please Select</option>
                    <option value="AJ">AJ</option>
                    <option value="Paul">Paul</option>
                    <option value="Other">Other</option>
                    <option value="None">None</option>
                </select>
            </div>

            <div class="form-group" id="referral_other_container" style="display:none">
                <label>Please specify</label>
                <input id="referral_other" disabled name="referral_other" placeholder="" type="text" class="form-control" />
            </div>


            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="tandccheck">
                <label class="form-check-label" for="tandccheck">I agree with terms and conditions</label>
            </div>

            <button class="btn btn-primary mt-3">Submit Payment</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            $(".form-wrap").height($(window).height());

            $('#referral').on('change', function() {
                if (this.value === "Other") {
                    $('#referral_other_container').show();
                    $('#referral_other').removeAttr('disabled');
                }
            });


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
        var card = elements.create('card', {
            style: style
        });

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