@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create New Location</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/locations/')}}" method="post">
              {{csrf_field()}}
              <div class="box-body">


                <div class="col-md-9 form-group {{ $errors->has('location_name') ? ' has-error' : '' }}">
                  <label for="name">Location Name</label>
                  <input type="text" class="form-control" id="location_name" name="location_name" placeholder="" value="{{old('location_name')}}" required autofocus>
                </div>

                <div class="col-md-9 form-group {{ $errors->has('location_code') ? ' has-error' : '' }}">
                  <label for="name">Location Code</label>
                  <input type="text" class="form-control" id="location_code" name="location_code" placeholder="" value="{{old('location_code')}}" required autofocus>
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
            $( "#trial_start_date" ).datepicker();
            $( "#billing_start_date" ).datepicker();
            $( "#termination_date" ).datepicker();
        } 
    );
  </script>

@endpush

@endsection
