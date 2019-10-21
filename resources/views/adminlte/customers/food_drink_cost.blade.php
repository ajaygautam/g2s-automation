@extends('adminlte.layouts.app')

@push('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endpush

@section('content')

   <!-- Main content -->
   <section class="content">
      
      <div class="row">
        <div class="col-md-4">
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Add Charge</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ url('/dashboard/customers/save_food_drink_charges/')}}/{{$customer->id}}" method="post" id="payment-form">
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

                <div class="form-group col-md-6  {{ $errors->has('cost') ? ' has-error' : '' }}">
                  <label>Amount</label>   
                  
                  <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input id="cost" name="cost" placeholder="" type="text" class="form-control"  />
                  </div>
                  
                </div>

                <div class="col-md-6 form-group  {{ $errors->has('consumed_on') ? ' has-error' : '' }}">
                    <label for="name">Consumed On</label>
                      <input name="consumed_on" id="consumed_on" autocomplete="off" type="text" 
                      class="form-control" value="{{old('consumed_on',date('Y-m-d'))}}" />
                  </div>
                
                <div class="form-group col-md-12  {{ $errors->has('description') ? ' has-error' : '' }}">
                  <label>Description</label>    
                  <input id="description" name="description" placeholder="" 
                  type="text" class="form-control"  />
                </div>
                  
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button class="btn btn-primary mt-3">Save Charge</button>
                <a href="javascript: history.go(-1)" class="btn btn-default">Cancel</a>
              </div>
            </form>
          </div>

        </div>

       <div class="col-md-8">
        <div class="box box-primary">
          <div class="box-header with-border">
                <h3 class="box-title">Previous Charge This Month  <u><b>[${{isset($customer->food_drink_charges_monthly_total->total_monthly)?$customer->food_drink_charges_monthly_total->total_monthly:'0'}}]</bu></u></h3>
            </div>
           <!-- /.box-header -->
           <div class="box-body">
              <table id="food_charges_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Description</th>
                  <th>Actions</th>                  
                </tr>
                </thead>
                <tbody>
                  @foreach($customer->food_drink_charges as $charge)  
                  <tr>
                    <th>{{format_date($charge->consumed_on,'2')}}</th>
                    <th>${{$charge->cost}}</th>
                    <th>{{$charge->description}}</th>
                    <th>
                      <a href="{{url('/dashboard/customers/delete_food_drink_charge/'.$charge->id)}}"><i class="fa fa-trash text-danger"></i></a>
                    </th>                  
                  </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
            <!-- /.box-body -->

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
<!-- DataTables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

<script>
  $( function() {
    $( "#consumed_on" ).datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      });
  } );
</script>


<script>
  $(document).ready(function() {
    $('#food_charges_table').DataTable({
      "processing": true,
      "serverSide": false,
      "bFilter": false,
      "paging": false,
      "order": [[ 0, "desc" ]],
    });
});
</script>

@endpush

@endsection
