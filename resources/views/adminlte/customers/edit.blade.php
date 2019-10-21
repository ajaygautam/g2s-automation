@extends('adminlte.layouts.app')

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
@endpush

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-8">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Customer Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/customers/')}}/{{$customer->id}}" method="post" id="basic-form">
              {{csrf_field()}}
              {{method_field('PUT')}}
              <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              <div class="col-md-6 form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label for="fname">First Name</label>
                    <input name="first_name" id="first_name"  type="text" class="form-control" value="{{$customer->first_name}}"/>
              </div>
              
              <div class="col-md-6 form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label for="lname">Last Name</label>
                    <input name="last_name" id="last_name"  type="text" class="form-control" value="{{$customer->last_name}} "/>
              </div>

              <div class="col-md-4 form-group {{ $errors->has('primary_email') ? ' has-error' : '' }}">
                <label for="name">Email 1</label>
                  <input name="primary_email" type="email" class="form-control"  value="{{ $customer->email}}" required/>
              </div>

              <div class="col-md-4 form-group {{ $errors->has('email2') ? ' has-error' : '' }}">
                <label for="name">Email 2</label>
                  <input name="email_2" type="email" class="form-control"  value="{{$customer->email_2}}"/>
              </div>

              <div class="col-md-4 form-group">
                <label for="name">Email 3</label>
                  <input name="email_3" type="email" class="form-control"  value="{{$customer->email_3}}"/>
              </div>

              <div class="col-md-4 form-group {{ $errors->has('phone1') ? ' has-error' : '' }}">
                <label for="name">Phone 1</label>
                  <input name="phone_1" type="text" class="form-control"  value="{{ $customer->phone_1}}" />
              </div>

              <div class="col-md-4 form-group {{ $errors->has('phone2') ? ' has-error' : '' }}">
                <label for="name">Phone 2</label>
                  <input name="phone_2" type="text" class="form-control"  value="{{$customer->phone_2}}"/>
              </div>

              <div class="col-md-4 form-group">
                <label for="name">Phone 3</label>
                  <input name="phone_3" type="text" class="form-control"  value="{{$customer->phone_3}}"/>
              </div>

              <div class="col-md-6 form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="name">Password</label>
                  <input name="password" type="password" class="form-control" />
              </div>

              <div class="clearfix">&nbsp;</div>

              <div class="col-md-9 form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="name">Address</label>
                <input name="address" placeholder="" type="text" class="form-control" value="{{$customer->address}}"  required/>
              </div>

              <div class="col-md-6 form-group">
                    <label>City</label>
                    <input name="city" placeholder="" type="text" class="form-control"  value="{{$customer->city}}" required/>
              </div>
             
              <div class="col-md-6 form-group">
                    <label>State</label>
                    <select name="state" id="state" class="form-control" required >
                        <option value="">Please select</option>
                        <option value="AL" {{$customer->state=="AL"?"selected":""}}>Alabama</option>
                        <option value="AK" {{$customer->state=="AK"?"selected":""}}>Alaska</option>
                        <option value="AZ" {{$customer->state=="AZ"?"selected":""}}>Arizona</option>
                        <option value="AR" {{$customer->state=="AR"?"selected":""}}>Arkansas</option>
                        <option value="CA" {{$customer->state=="CA"?"selected":""}}>California</option>
                        <option value="CO" {{$customer->state=="CO"?"selected":""}}>Colorado</option>
                        <option value="CT" {{$customer->state=="CT"?"selected":""}}>Connecticut</option>
                        <option value="DE" {{$customer->state=="DE"?"selected":""}}>Delaware</option>
                        <option value="DC" {{$customer->state=="AL"?"selected":""}}>District Of Columbia</option>
                        <option value="FL" {{$customer->state=="FL"?"selected":""}}>Florida</option>
                        <option value="GA" {{$customer->state=="GA"?"selected":""}}>Georgia</option>
                        <option value="HI" {{$customer->state=="HI"?"selected":""}}>Hawaii</option>
                        <option value="ID" {{$customer->state=="ID"?"selected":""}}>Idaho</option>
                        <option value="IL" {{$customer->state=="IL"?"selected":""}}>Illinois</option>
                        <option value="IN" {{$customer->state=="IN"?"selected":""}}>Indiana</option>
                        <option value="IA" {{$customer->state=="IA"?"selected":""}}>Iowa</option>
                        <option value="KS" {{$customer->state=="KS"?"selected":""}}>Kansas</option>
                        <option value="KY" {{$customer->state=="KY"?"selected":""}}>Kentucky</option>
                        <option value="LA" {{$customer->state=="LA"?"selected":""}}>Louisiana</option>
                        <option value="ME" {{$customer->state=="ME"?"selected":""}}>Maine</option>
                        <option value="MD" {{$customer->state=="MD"?"selected":""}}>Maryland</option>
                        <option value="MA" {{$customer->state=="MA"?"selected":""}}>Massachusetts</option>
                        <option value="MI" {{$customer->state=="MI"?"selected":""}}>Michigan</option>
                        <option value="MN" {{$customer->state=="MN"?"selected":""}}>Minnesota</option>
                        <option value="MS" {{$customer->state=="MS"?"selected":""}}>Mississippi</option>
                        <option value="MO" {{$customer->state=="MO"?"selected":""}}>Missouri</option>
                        <option value="MT" {{$customer->state=="MT"?"selected":""}}>Montana</option>
                        <option value="NE" {{$customer->state=="NE"?"selected":""}}>Nebraska</option>
                        <option value="NV" {{$customer->state=="NV"?"selected":""}}>Nevada</option>
                        <option value="NH" {{$customer->state=="NH"?"selected":""}}>New Hampshire</option>
                        <option value="NJ" {{$customer->state=="NJ"?"selected":""}}>New Jersey</option>
                        <option value="NM" {{$customer->state=="NM"?"selected":""}}>New Mexico</option>
                        <option value="NY" {{$customer->state=="NY"?"selected":""}}>New York</option>
                        <option value="NC" {{$customer->state=="NC"?"selected":""}}>North Carolina</option>
                        <option value="ND" {{$customer->state=="ND"?"selected":""}}>North Dakota</option>
                        <option value="OH" {{$customer->state=="OH"?"selected":""}}>Ohio</option>
                        <option value="OK" {{$customer->state=="OK"?"selected":""}}>Oklahoma</option>
                        <option value="OR" {{$customer->state=="OR"?"selected":""}}>Oregon</option>
                        <option value="PA" {{$customer->state=="PA"?"selected":""}}>Pennsylvania</option>
                        <option value="RI" {{$customer->state=="RI"?"selected":""}}>Rhode Island</option>
                        <option value="SC" {{$customer->state=="SC"?"selected":""}}>South Carolina</option>
                        <option value="SD" {{$customer->state=="SD"?"selected":""}}>South Dakota</option>
                        <option value="TN" {{$customer->state=="TN"?"selected":""}}>Tennessee</option>
                        <option value="TX" {{$customer->state=="TX"?"selected":""}}>Texas</option>
                        <option value="UT" {{$customer->state=="UT"?"selected":""}}>Utah</option>
                        <option value="VT" {{$customer->state=="VT"?"selected":""}}>Vermont</option>
                        <option value="VA" {{$customer->state=="VA"?"selected":""}}>Virginia</option>
                        <option value="WA" {{$customer->state=="WA"?"selected":""}}>Washington</option>
                        <option value="WV" {{$customer->state=="WV"?"selected":""}}>West Virginia</option>
                        <option value="WI" {{$customer->state=="WI"?"selected":""}}>Wisconsin</option>
                        <option values="WY" {{$customer->state=="WY"?"selected":""}}>Wyoming</option>
                        </select>
              </div>

              <div class="col-md-6 form-group">
                    <label>County</label>
                    <input name="county" placeholder="" type="text" class="form-control" 
                    value="{{$customer->county}}" />
              </div>

              <div class="col-md-6 form-group">
                    <label>Zip Code</label>
                    <input name="zipcode" placeholder="" type="text" class="form-control"  value="{{$customer->zipcode}}" required />
              </div>

              <div class="col-md-6 form-group">
                  <label>Country</label>
                    <select name="country" id="country" class="form-control"  >
                        <option value="">Please select</option>
                        <option value="USA" selected>US</option>
                    </select>
              </div>

              <div class="clearfix"></div>
    
            <div class="form-group col-md-6">
                <label>Referred By</label>
                <select name="referral" id="referral" class="form-control"  >
                    <option value="">Please Select</option>
                    <option value="AJ" {{$customer->customerPlan->referral=="AJ"?"selected":""}}>AJ</option>
                    <option value="Paul" {{$customer->customerPlan->referral=="Paul"?"selected":""}}>Paul</option>
                    <option value="Other" {{$customer->customerPlan->referral=="Other"?"selected":""}}>Other</option>
                    <option value="None" {{$customer->customerPlan->referral=="None"?"selected":""}}>None</option>
                </select>
            </div>

            <div class="form-group col-md-6" id="referral_other_container" style="display:{{$customer->customerPlan->referral=='Other'?'block':'none'}}">
                <label>Please specify</label>
                <input id="referral_other" {{$customer->customerPlan->referral!='Other'?'disabled':''}}  name="referral_other" placeholder="" type="text" class="form-control" value="{{$customer->customerPlan->referral_other}}" />
            </div>

                
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button class="btn btn-primary mt-3">Submit</button>
                <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
              </div>
            </form>
          </div>

        </div>

        <!-- RIGHT COLUMN -->
        
        <div class="col-md-4">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Membership Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/customers/update_membership/')}}/{{$customer->id}}" method="post" id="membership-form">
              {{csrf_field()}}
              
              <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-md-6 form-group">
                    <label>Membership Plan</label>
                    <select name="membership_plan_id" id="membership_plan_id" class="form-control"  >
                            <option value="">Please select</option>
                            @foreach($plans as $key=>$plan)
                            <option value="{{$plan->id}}" 
                                {{$customer->customerPlan->membership_plan_id==$plan->id?"selected":""}}
                                >{{$plan->plan_name}}</option>
                            @endforeach
                    </select>
                </div>
          
                <div class="col-md-6 form-group {{ $errors->has('plan_starts_on') ? ' has-error' : '' }}">
                    <label for="name">Plan Starts On</label>
                    <input name="plan_starts_on" id="plan_starts_on" autocomplete="off" type="text" class="form-control" value="{{isset($customer->customerPlan)?$customer->customerPlan->plan_starts_on:''}}" />
                </div>
                
                <div class="form-group col-md-12">
                    <label>Commitment Type</label>    
                        <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="yearly_commitment" value='1' {{$customer->customerPlan->yearly_commitment==1?"checked=checked":""}}> Yearly
                        </label>
                            &nbsp;
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="yearly_commitment" value='0' {{$customer->customerPlan->yearly_commitment=="0"?"checked=checked":""}}> Monthly
                        </label>
                    </div>
                </div>
                
                <div class="form-group col-md-12">
                    <label>Hold Status</label>    
                        <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="is_plan_hold" value='1' {{$customer->customerPlan->is_plan_hold==1?"checked=checked":""}}> Yes
                        </label>
                            &nbsp;
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="is_plan_hold" value='0' {{$customer->customerPlan->is_plan_hold=="0"?"checked=checked":""}}> No
                        </label>
                    </div>
                </div>

                @if($customer->customerPlan->plan_hold_starts_on!='')
                <div class="col-md-6 form-group">
                    <label for="name">Hold Started On</label>
                    <span class="form-control">{{$customer->customerPlan->plan_hold_starts_on}}</span>
                </div>
                @endif

                @if($customer->customerPlan->plan_hold_starts_on!='')
                <div class="col-md-6 form-group">
                    <label for="name">Hold Ended On</label>
                    <span class="form-control">{{$customer->customerPlan->plan_hold_ends_on}}</span>
                </div>
                @endif
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button class="btn btn-primary mt-3">Submit</button>
                <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
              </div>
            </form>
          </div>
         
          <!-------------------------------------------- -->
         
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Card details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/customers/update_card/')}}/{{$customer->id}}" method="post" id="payment-form">
              {{csrf_field()}}
              
              <div class="box-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


  

         


            <div class="form-group col-md-12">
            <label>Charge the Customer?</label>    

                <div class="form-check-inline">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="charge_customer" value='1' {{old('charge_customer','0')==1?"checked=checked":""}}> Yes
                    </label>
               &nbsp;
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="charge_customer" value='0' {{old('charge_customer','0')=="0"?"checked=checked":""}}> No
                    </label>
                </div>
            </div>



            <div class="form-group col-md-12">
                <label>Credit card Info</label>
                <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                </div>

                <div id="card-errors" class="text-danger" role="alert"></div>
            </div>
              
           

           
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button class="btn btn-primary mt-3">Submit Payment</button>
                <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
              </div>
            </form>
          </div>

        </div>

        


    </div>
</section>

@push('styles')
<style>
  .nopadding {
    padding: 0 !important;
    margin: 0 !important;
  }
</style>
@endpush
   
   
@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  <script>
  $( function() {
    $( "#plan_starts_on" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      });
  } );
  </script>



  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
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
        var stripe = Stripe("{{config('settings.keys.STRIPE_KEY')}}");

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

@endpush

@endsection
