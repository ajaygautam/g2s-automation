@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Location</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/locations/'.$location->id)}}" method="post">
              {{csrf_field()}}
              {{method_field('PUT')}}
              
              <div class="box-body">


                <div class="col-md-9 form-group {{ $errors->has('location_name') ? ' has-error' : '' }}">
                  <label for="name">Location Name</label>
                  <input type="text" class="form-control" id="location_name" name="location_name" placeholder="" value="{{$location->location_name}}" required autofocus>
                </div>

                <div class="col-md-9 form-group {{ $errors->has('location_code') ? ' has-error' : '' }}">
                  <label for="name">Location Code</label>
                  <input type="text" class="form-control" id="location_code" name="location_code" placeholder="" value="{{$location->location_code}}" required >
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

@endpush

@endsection
