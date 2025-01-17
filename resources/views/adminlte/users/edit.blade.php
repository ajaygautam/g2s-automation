@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-8">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/users/')}}/{{$user->id}}" method="post">
              <input type="hidden" name="_method" value="PUT" />
              {{csrf_field()}}
              <div class="box-body">
                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                  <label for="name">First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="" value="{{$user->first_name}}" required autofocus>
                </div>

                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                  <label for="name">Last Name</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="" value="{{$user->last_name}}" required>
                </div>

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="" required>
                </div>
                
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                  <label for="password">Password</label>
                  <input type="text" class="form-control" id="password" name="password" value="" placeholder="" >
                </div>
                  
                    
                <div class="form-group {{ $errors->has('home_location_code') ? ' has-error' : '' }}">
                  <label for="password">Home Location Code</label>
                  
                  <select name="home_location_code" id="home_location_code" class="form-control">
                      <option value="">Please Select</option>
                      @foreach($locations as $lc)
                         <option value="{{$lc->location_code}}" {{$user->home_location_code==$lc->location_code?"selected":""}}>{{$lc->location_name}}</option>
                      @endforeach
                  </select>
               
                </div>
                  


                <div class="form-group {{ $errors->has('customer_type') ? ' has-error' : '' }}">
                  <label for="user_type">Customer Type</label>
                  <select name="customer_type" id="customer_type" class="form-control">
                      <option value="">Please Select</option>
                      @foreach($customer_types as $c)
                      <option value="{{$c->id}}" {{$user->customer_type==$c->id?"selected":""}}>{{$c->customer_type_name}}</option>
                      @endforeach
                      
                  </select>
                  
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
