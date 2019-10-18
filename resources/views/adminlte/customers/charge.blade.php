@extends('adminlte.layouts.app')

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
@endpush

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
       
        
        <div class="col-md-4">
      
       
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Charge</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/customers/process_charge/')}}/{{$customer->id}}" method="post" id="payment-form">
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
              <label>Amount</label>    
              <input id="charge_amount" name="charge_amount" placeholder="" 
              type="text" class="form-control"  />
            </div>
            
            <div class="form-group col-md-12">
              <label>Comments</label>    
              <input id="comments" name="comments" placeholder="" 
              type="text" class="form-control"  />
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
  
  



  <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function() {
                 

        $(".form-wrap").height($(window).height());

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
