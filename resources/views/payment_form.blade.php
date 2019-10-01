<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Payment Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/general.css')}}">
    <link rel="stylesheet" href="{{asset('css/payment_form.css')}}">

</head>

<body>
<div class="form-wrap d-flex justify-content-center align-items-center">


    <form action="{{url('/stripe_subscription')}}" method="post" id="payment-form">
            @csrf
            <input type="hidden" name="plan_code" value="{{$plan->plan_code}}" />

            <div class="top-wrap mb-3">
                <h3 class="text-center mb-0">MEMBERSHIP</h3>
                <h6 class="text-center mb-1">Info and payment details</h6>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <label>Name</label>
                <input name="customer_name" id="customer_name" placeholder="Enter Full Name" type="text" class="form-control" value="{{old('customer_name')}}"/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input name="primary_email" placeholder="Enter your email address" type="email" class="form-control"  value="{{old('primary_email')}}"/>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" class="form-control"  required/>
            </div>
            
            <div class="form-group">
                <label>Confirm Password</label>
                <input name="cpassword" type="password" class="form-control"  required/>
            </div>

            <hr />

            <div class="form-group">
                <label>Address</label>
                <input name="address" placeholder="" type="text" class="form-control" value="{{old('address')}}"  required/>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>City</label>
                        <input name="city" placeholder="" type="text" class="form-control"  value="{{old('city')}}" required/>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>State</label>
                        <select name="state" id="state" class="form-control" required >
                        <option value="">Please select</option>
                        <option value="AL" {{old('state','CT')=="AL"?"selected":""}}>Alabama</option>
                        <option value="AK" {{old('state','CT')=="AK"?"selected":""}}>Alaska</option>
                        <option value="AZ" {{old('state','CT')=="AZ"?"selected":""}}>Arizona</option>
                        <option value="AR" {{old('state','CT')=="AR"?"selected":""}}>Arkansas</option>
                        <option value="CA" {{old('state','CT')=="CA"?"selected":""}}>California</option>
                        <option value="CO" {{old('state','CT')=="CO"?"selected":""}}>Colorado</option>
                        <option value="CT" {{old('state','CT')=="CT"?"selected":""}}>Connecticut</option>
                        <option value="DE" {{old('state','CT')=="DE"?"selected":""}}>Delaware</option>
                        <option value="DC" {{old('state','CT')=="AL"?"selected":""}}>District Of Columbia</option>
                        <option value="FL" {{old('state','CT')=="FL"?"selected":""}}>Florida</option>
                        <option value="GA" {{old('state','CT')=="GA"?"selected":""}}>Georgia</option>
                        <option value="HI" {{old('state','CT')=="HI"?"selected":""}}>Hawaii</option>
                        <option value="ID" {{old('state','CT')=="ID"?"selected":""}}>Idaho</option>
                        <option value="IL" {{old('state','CT')=="IL"?"selected":""}}>Illinois</option>
                        <option value="IN" {{old('state','CT')=="IN"?"selected":""}}>Indiana</option>
                        <option value="IA" {{old('state','CT')=="IA"?"selected":""}}>Iowa</option>
                        <option value="KS" {{old('state','CT')=="KS"?"selected":""}}>Kansas</option>
                        <option value="KY" {{old('state','CT')=="KY"?"selected":""}}>Kentucky</option>
                        <option value="LA" {{old('state','CT')=="LA"?"selected":""}}>Louisiana</option>
                        <option value="ME" {{old('state','CT')=="ME"?"selected":""}}>Maine</option>
                        <option value="MD" {{old('state','CT')=="MD"?"selected":""}}>Maryland</option>
                        <option value="MA" {{old('state','CT')=="MA"?"selected":""}}>Massachusetts</option>
                        <option value="MI" {{old('state','CT')=="MI"?"selected":""}}>Michigan</option>
                        <option value="MN" {{old('state','CT')=="MN"?"selected":""}}>Minnesota</option>
                        <option value="MS" {{old('state','CT')=="MS"?"selected":""}}>Mississippi</option>
                        <option value="MO" {{old('state','CT')=="MO"?"selected":""}}>Missouri</option>
                        <option value="MT" {{old('state','CT')=="MT"?"selected":""}}>Montana</option>
                        <option value="NE" {{old('state','CT')=="NE"?"selected":""}}>Nebraska</option>
                        <option value="NV" {{old('state','CT')=="NV"?"selected":""}}>Nevada</option>
                        <option value="NH" {{old('state','CT')=="NH"?"selected":""}}>New Hampshire</option>
                        <option value="NJ" {{old('state','CT')=="NJ"?"selected":""}}>New Jersey</option>
                        <option value="NM" {{old('state','CT')=="NM"?"selected":""}}>New Mexico</option>
                        <option value="NY" {{old('state','CT')=="NY"?"selected":""}}>New York</option>
                        <option value="NC" {{old('state','CT')=="NC"?"selected":""}}>North Carolina</option>
                        <option value="ND" {{old('state','CT')=="ND"?"selected":""}}>North Dakota</option>
                        <option value="OH" {{old('state','CT')=="OH"?"selected":""}}>Ohio</option>
                        <option value="OK" {{old('state','CT')=="OK"?"selected":""}}>Oklahoma</option>
                        <option value="OR" {{old('state','CT')=="OR"?"selected":""}}>Oregon</option>
                        <option value="PA" {{old('state','CT')=="PA"?"selected":""}}>Pennsylvania</option>
                        <option value="RI" {{old('state','CT')=="RI"?"selected":""}}>Rhode Island</option>
                        <option value="SC" {{old('state','CT')=="SC"?"selected":""}}>South Carolina</option>
                        <option value="SD" {{old('state','CT')=="SD"?"selected":""}}>South Dakota</option>
                        <option value="TN" {{old('state','CT')=="TN"?"selected":""}}>Tennessee</option>
                        <option value="TX" {{old('state','CT')=="TX"?"selected":""}}>Texas</option>
                        <option value="UT" {{old('state','CT')=="UT"?"selected":""}}>Utah</option>
                        <option value="VT" {{old('state','CT')=="VT"?"selected":""}}>Vermont</option>
                        <option value="VA" {{old('state','CT')=="VA"?"selected":""}}>Virginia</option>
                        <option value="WA" {{old('state','CT')=="WA"?"selected":""}}>Washington</option>
                        <option value="WV" {{old('state','CT')=="WV"?"selected":""}}>West Virginia</option>
                        <option value="WI" {{old('state','CT')=="WI"?"selected":""}}>Wisconsin</option>
                        <option values="WY" {{old('state','CT')=="WY"?"selected":""}}>Wyoming</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>County</label>
                        <input name="county" placeholder="" type="text" class="form-control" value="{{old('county')}}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Zip Code</label>
                        <input name="zipcode" placeholder="" type="text" class="form-control"  value="{{old('zipcode')}}" required />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Country</label>
                <select name="country" id="country" class="form-control"  >
                    <option value="">Please select</option>
                    <option value="USA" selected>US</option>
                </select>
            </div>

            <hr />

            <div class="form-group">
                <label>Membership Plan</label>
                <span class="form-control">{{$plan->plan_name}}</span>
            </div>
            
            <div class="form-group">
                <label>Membership details</label>
                <div class="details-wrap">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Included Peak Hours</span> <span><strong>{{$plan->included_peak_hours}} hours</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Included Off-Peak Hours</span> <span><strong>{{$plan->included_off_peak_hours}} hours</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Included Lessons</span> <span><strong>{{$plan->included_lessons}}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Overage Discount </span> <span><strong>{{$plan->play_discount}}%</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Food & Drinks Discount</span> <span><strong>{{$plan->food_discount}}%</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Events Discount</span> <span><strong>{{$plan->events_discount}}%</strong></span>
                    </div>
                    <hr class="m-0 mb-1">
                    <div class="d-flex justify-content-between ">
                        <span>Monthly Due - Yearly Commitment - On Season</span> <span><strong>${{$plan->monthly_due_on_season_yc}}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between ">
                        <span>Monthly Due - Yearly Commitment -  Off Season</span> <span><strong>${{$plan->monthly_due_off_season_yc}}</strong></span>
                    </div>
                    <hr class="m-0 mb-1">
                    <div class="d-flex justify-content-between ">
                        <span>Monthly Due - Monthly Commitment - On Season</span> <span><strong>${{$plan->monthly_due_on_season_mc}}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between ">
                        <span>Monthly Due - Monthly Commitment -  Off Season</span> <span><strong>${{$plan->monthly_due_off_season_mc}}</strong></span>
                    </div>
                </div>
            </div>
            
            <label>Commitment Type</label>    

            <div class="form-group">
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="yearly_commitment" value='1' {{old('yearly_commitment','1')==1?"checked=checked":""}}> Yearly
                    </label>
                </div>
                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="yearly_commitment" value='0' {{old('yearly_commitment','1')=="0"?"checked=checked":""}}> Monthly
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label>Payment details</label>    
                <div class="details-wrap">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fees</span> <span id="yearly_cost"><strong>${{$monthly_due_season_yc}}</strong></span> <span id="monthly_cost"><strong>${{$monthly_due_season_mc}}</strong></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax ({{$tax}}%) </span> <span id="yearly_tax"><strong>${{($monthly_due_season_yc*$tax)/100}}</strong></span><span id="monthly_tax"><strong>${{($monthly_due_season_mc*$tax)/100}}</strong></span>
                    </div>
                    <hr class="m-0 mb-1">
                    <div class="d-flex justify-content-between ">
                        <span>Total</span> <span id="yearly_total"><strong>
                            $<?php echo 
                                $monthly_due_season_yc + ($monthly_due_season_yc*$tax)/100;
                            ?>
                        </strong></span><span id="monthly_total"><strong>
                            $<?php echo 
                                $monthly_due_season_mc + ($monthly_due_season_mc*$tax)/100;
                            ?>
                        </strong></span>
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
                <select name="referral" id="referral" class="form-control"  >
                    <option value="">Please Select</option>
                    <option value="AJ" {{old('referral')=="AJ"?"selected":""}}>AJ</option>
                    <option value="Paul" {{old('referral')=="Paul"?"selected":""}}>Paul</option>
                    <option value="Other" {{old('referral')=="Other"?"selected":""}}>Other</option>
                    <option value="None" {{old('referral')=="None"?"selected":""}}>None</option>
                </select>
            </div>

            <div class="form-group" id="referral_other_container" style="display:none">
                <label>Please specify</label>
                <input id="referral_other" disabled name="referral_other" placeholder="" type="text" class="form-control" value="{{old('referral_other')}}" />
            </div>


            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="tandccheck" name="tandccheck" >
                <label class="form-check-label" for="tandccheck">I agree with terms and conditions</label>
            </div>

            <button class="btn btn-primary mt-3">Submit Payment</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
            
            if($('input:radio[name="yearly_commitment"]').val()==1)
            {
                $("#yearly_cost").show();
                $("#yearly_tax").show();
                $("#yearly_total").show();
                $("#monthly_cost").hide();
                $("#monthly_tax").hide();
                $("#monthly_total").hide();
            }else{
                $("#yearly_cost").hide();
                $("#yearly_tax").hide();
                $("#yearly_total").hide();
                $("#monthly_cost").show();
                $("#monthly_tax").show();
                $("#monthly_total").show();

            }


            $('input:radio[name="yearly_commitment"]').change(
                function(){
                    if ($(this).val() == '1') {
                        $("#yearly_cost").show();
                        $("#yearly_tax").show();
                        $("#yearly_total").show();
                        $("#monthly_cost").hide();
                        $("#monthly_tax").hide();
                        $("#monthly_total").hide();
                    }
                    else {
                        $("#yearly_cost").hide();
                        $("#yearly_tax").hide();
                        $("#yearly_total").hide();
                        $("#monthly_cost").show();
                        $("#monthly_tax").show();
                        $("#monthly_total").show();

                    }
            });

        //     var password = document.getElementById("password") ;
        //     var  confirm_password = document.getElementById("cpassword");

        // function validatePassword(){
        //     console.log('dasasda');
        //     if(password.value != confirm_password.value) {
        //         confirm_password.setCustomValidity("Passwords Don't Match");
        //     } else {
        //         confirm_password.setCustomValidity('');
        //     }
        // }

        // password.onchange = validatePassword;
        // confirm_password.onkeyup = validatePassword;

        $(".form-wrap").height($(window).height());

        $('#referral').on('change', function() {
            if (this.value === "Other") {
                $('#referral_other_container').show();
                $('#referral_other').removeAttr('disabled');
                $('#referral_other').prop('',true);

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