@extends('adminlte.layouts.app')

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-6">
      
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create New Resource</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/resources/')}}" method="post">
              {{csrf_field()}}
              <div class="box-body">


                <div class="col-md-9 form-group {{ $errors->has('resource_name') ? ' has-error' : '' }}">
                  <label for="name">Resource Name</label>
                  <input type="text" class="form-control" id="resource_name" name="resource_name" placeholder="" value="{{old('resource_name')}}" required autofocus>
                </div>

                <div class=" col-md-4 form-group {{ $errors->has('resource_type') ? ' has-error' : '' }}">
                  <label for="email">Resource Type</label>
                  <select id="resource_type" name="resource_type" class="form-control">
                    <option value="">Please Select</option>
                    <option value="1" selected>Bay</option>
                    <!-- <option value="2">Instructor</option> -->
                  </select>
                </div>

                <div class="form-group col-md-8" style="min-height:60px">&nbsp;</div>

               
                <div class=" col-md-4 form-group {{ $errors->has('peak_price') ? ' has-error' : '' }}">
                  <label for="email">Peak Hours Price </label>
                  <input type="text" class="form-control" id="peak_price" name="peak_price" value="{{old('peak_price')}}" placeholder="" required>
                </div>
                
                <div class=" col-md-4 form-group {{ $errors->has('off_peak_price') ? ' has-error' : '' }}">
                  <label for="email">Off Peak Hours Price</label>
                  <input type="text" class="form-control" id="off_peak_price" name="off_peak_price" value="{{old('off_peak_price')}}" placeholder="" required>
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


@endsection
