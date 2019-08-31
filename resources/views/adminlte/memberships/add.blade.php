@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create New Membership Plan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/memberships/')}}" method="post">
              {{csrf_field()}}
              <div class="box-body">


                <div class="col-md-9 form-group {{ $errors->has('plan_name') ? ' has-error' : '' }}">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="" value="{{old('plan_name')}}" required autofocus>
                </div>

                <div class="col-md-9 form-group {{ $errors->has('stripe_product_id') ? ' has-error' : '' }}">
                  <label for="email">Stripe Product ID
                    <small>( ex: prod_Fc8lbdYB80MaKb)</small>
                  </label>
                  <input type="text" class="form-control" id="stripe_product_id" name="stripe_product_id" value="{{old('stripe_product_id')}}" placeholder="" required>
                </div>
               
                
               <!-- ////////// -->
                <div class=" col-md-4 form-group {{ $errors->has('included_peak_hours') ? ' has-error' : '' }}">
                  <label for="email">Included Peak Hours</label>
                  <input type="text" class="form-control" id="included_peak_hours" name="included_peak_hours" value="{{old('included_peak_hours')}}" placeholder="" required>
                </div>
                
                <div class=" col-md-4 form-group {{ $errors->has('included_off_peak_hours') ? ' has-error' : '' }}">
                  <label for="email">Included Off Peak Hours</label>
                  <input type="text" class="form-control" id="included_off_peak_hours" name="included_off_peak_hours" value="{{old('included_off_peak_hours')}}" placeholder="" required>
                </div>

                <div class=" col-md-4 form-group {{ $errors->has('included_lessons') ? ' has-error' : '' }}">
                  <label for="email">Included Lessons</label>
                  <input type="text" class="form-control" id="included_lessons" name="included_lessons" value="{{old('included_lessons')}}" placeholder="" required>
                </div>

               
                <div class=" col-md-4 form-group {{ $errors->has('play_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Additional Hours </label>
                  <input type="text" class="form-control" id="play_discount" name="play_discount" value="{{old('play_discount')}}" placeholder="" required>
                </div>
               
                <div class=" col-md-4 form-group {{ $errors->has('food_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Food</label>
                  <input type="text" class="form-control" id="food_discount" name="food_discount" value="{{old('food_discount')}}" placeholder="" required>
                </div>

                <div class=" col-md-4 form-group {{ $errors->has('events_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Events</label>
                  <input type="text" class="form-control" id="events_discount" name="events_discount" value="{{old('events_discount')}}" placeholder="" required>
                </div>

                <div class=" col-md-3 form-group {{ $errors->has('monthly_due_on_season') ? ' has-error' : '' }}">
                  <label for="email">Monthly Due on Season</label>
                  <input type="text" class="form-control" id="monthly_due_on_season" name="monthly_due_on_season" value="{{old('monthly_due_on_season')}}" placeholder="" required>
                </div>

                <div class=" col-md-3  form-group {{ $errors->has('monthly_due_off_season') ? ' has-error' : '' }}">
                  <label for="email">Monthly Due off Season</label>
                  <input type="text" class="form-control" id="monthly_due_off_season" name="monthly_due_off_season" value="{{old('monthly_due_off_season')}}" placeholder="" required>
                </div>

                
               
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
              </div>
            </form>
          </div>

        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush
   
   
@push('scripts')

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
    $( function() {
            $( "#trial_start_date" ).datepicker();
            $( "#billing_start_date" ).datepicker();
            $( "#termination_date" ).datepicker();
        } 
    );
  </script>

@endpush

@endsection
