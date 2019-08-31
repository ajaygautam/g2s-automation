@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Profile Pic</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/profile/upload_pic') }}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}
              <div class="box-body">
                <div class="form-group">
                    <center>
                     <img src="{{Auth::user()->profile_pic!=''?asset('dist/images/'.Auth::user()->profile_pic):asset('dist/images/user2.jpg')}}" width="160px" class="img-circle" alt="User Image">
                    </center>
                </div>

                <div class="form-group">
                  <label for="website">Profile Pic</label>
                  <input type="file" class="form-control" 
                         id="profile_pic" name="profile_pic" required />
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
