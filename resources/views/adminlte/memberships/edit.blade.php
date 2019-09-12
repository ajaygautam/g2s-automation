@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Update Membership Plan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/memberships/'.$membership->id)}}" method="post">
              {{csrf_field()}}
              {{method_field('PUT')}}
              <div class="box-body">


                <div class="col-md-9 form-group {{ $errors->has('plan_name') ? ' has-error' : '' }}">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="" value="{{$membership->plan_name}}" required autofocus>
                </div>

                <div class="col-md-3 form-group {{ $errors->has('frequency') ? ' has-error' : '' }}">
                  <label for="name">Frequency</label>
                  <select class="form-control" id="frequency" name="frequency" required> 
                    <option value="">Please select</option>
                    <option value="0" {{$membership->frequency==0?"selected":""}}>Monthly</option>
                    <!-- <option value="1" {{$membership->frequency==1?"selected":""}}></option> -->
                    <option value="2" {{$membership->frequency==2?"selected":""}}>One off</option>
                  </select>
                </div>

               
                <div class=" col-md-4 form-group {{ $errors->has('included_peak_hours') ? ' has-error' : '' }}">
                  <label for="email">Included Peak Hours</label>
                  <input type="text" class="form-control" id="included_peak_hours" name="included_peak_hours" value="{{$membership->included_peak_hours}}" placeholder="" required>
                </div>
                
                <div class=" col-md-4 form-group {{ $errors->has('included_off_peak_hours') ? ' has-error' : '' }}">
                  <label for="email">Included Off Peak Hours</label>
                  <input type="text" class="form-control" id="included_off_peak_hours" name="included_off_peak_hours" value="{{$membership->included_off_peak_hours}}" placeholder="" required>
                </div>

                <div class=" col-md-4 form-group {{ $errors->has('included_lessons') ? ' has-error' : '' }}">
                  <label for="email">Included Lessons</label>
                  <input type="text" class="form-control" id="included_lessons" name="included_lessons" value="{{$membership->included_lessons}}" placeholder="" required>
                </div>

               
                <div class=" col-md-4 form-group {{ $errors->has('play_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Additional Hours </label>
                  <input type="text" class="form-control" id="play_discount" name="play_discount" value="{{$membership->play_discount}}" placeholder="" required>
                </div>
               
                <div class=" col-md-4 form-group {{ $errors->has('food_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Food</label>
                  <input type="text" class="form-control" id="food_discount" name="food_discount" value="{{$membership->food_discount}}" placeholder="" required>
                </div>

                <div class=" col-md-4 form-group {{ $errors->has('events_discount') ? ' has-error' : '' }}">
                  <label for="email">Discount on Events</label>
                  <input type="text" class="form-control" id="events_discount" name="events_discount" value="{{$membership->events_discount}}" placeholder="" required>
                </div>

                <div class=" col-md-3 form-group {{ $errors->has('monthly_due_on_season') ? ' has-error' : '' }}">
                  <label for="email">Monthly Due on Season</label>
                  <input type="text" class="form-control" id="monthly_due_on_season" name="monthly_due_on_season" value="{{$membership->monthly_due_on_season}}" placeholder="" required>
                </div>

                <div class=" col-md-3  form-group {{ $errors->has('monthly_due_off_season') ? ' has-error' : '' }}">
                  <label for="email">Monthly Due off Season</label>
                  <input type="text" class="form-control" id="monthly_due_off_season" name="monthly_due_off_season" value="{{$membership->monthly_due_off_season}}" placeholder="" required>
                </div>

                <div class="col-md-6" style="min-height:75px">&nbsp;</div>

                <label for="email" class="col-md-12 nopadding" >Plan Type</label>
                <div class=" col-md-3  form-group {{ $errors->has('plan_type') ? ' has-error' : '' }}">
                 
                  <label class="radio-inline">
                    <input type="radio" name="plan_type" value="0" {{$membership->plan_type==0?"checked":""}}>Public
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="plan_type" value="1" {{$membership->plan_type==1?"checked":""}}>Custom
                  </label>
                </div>
             
                
                <label for="email" class="col-md-12 nopadding" >Plan Link</label>
                <div class="col-md-12 form-group">
                  <div class="form-control">
                      {{url('payment_form/'.$membership->plan_code)}}
                  </div>
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
