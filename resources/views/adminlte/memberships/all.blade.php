@extends('adminlte.layouts.app')

@section('content')

@push('styles')
     <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  
@endpush


   <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Membership Plans</h3>
              <a href="{{url('/dashboard/memberships/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New Membership Plan</a>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="business_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Stripe ID</th>
                  <th>Customers</th>
                  <th>Peak Hours</th>
                  <th>Off Peak Hours</th>
                  <th>Additional Play Disc.</th>
                  <th>Food Disc.</th>
                  <th>Event Disc.</th>
                  <th>On Season</th>
                  <th>Off Season</th>
                  <th>Actions</th>
                  
                </tr>
                </thead>
                
                <tbody>
                  @foreach($allMemberships as $plan)
                  <tr>
                    <td>{{$plan->id}}</td>
                    <td>{{$plan->plan_name}}</td>
                    <td>{{$plan->stripe_product_id}}</td>
                    <td>{{count($plan->customers)}}</td>
                    <td>{{$plan->included_peak_hours=='-1'?'Unlimited':$plan->included_peak_hours}}</td>
                    <td>{{$plan->included_off_peak_hours=='-1'?'Unlimited':$plan->included_off_peak_hours}}</td>
                    <td>{{$plan->play_discount=='-1'?'Unlimited':$plan->play_discount.'%'}}</td>
                    <td>{{$plan->food_discount}}%</td>
                    <td>{{$plan->events_discount}}%</td>
                    <td>{{$plan->monthly_due_on_season=='0.00'?'Cost on Call': '$'.$plan->monthly_due_on_season}}</td>
                    <td>{{$plan->monthly_due_off_season=='0.00'?'Cost on Call': '$'.$plan->monthly_due_off_season}}</td>
                    <td>
                      <a href="/payments/{{$plan->id}}/edit"><i class="fa fa-pencil"></i></a>
                    </td>
                  </tr>
                  @endforeach

                </tbody>  

              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>


@push('scripts')
    
<!-- DataTables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.9/js/dataTables.checkboxes.min.js"></script>

<script>
  $(function () {
    $('#business_table').DataTable({
      "processing": true,
      "serverSide": false,
      "paging": false,
      "order": [[ 0, "desc" ]],
    });
    
  })
</script>

@endpush
@endsection