@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/update_password') }}" method="post" data-toggle="validator">
              {{csrf_field()}}
              <div class="box-body">
                <div class="form-group">
                  <label for="website">New Password</label>
                  <input type="password" class="form-control" id="password" name="password" required autofocus autocomplete="off">
                </div>

                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                    data-match="#password">
                </div>
                


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>

        </div>
    </div>
</section>


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.js"></script>

@endpush

@endsection
