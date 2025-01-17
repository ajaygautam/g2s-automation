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
              <h3 class="box-title">All Users</h3>
              <a href="#" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New Appointment</a>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="business_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Date</th>
                  <th>Actions</th>
                  
                </tr>
                </thead>
                
               
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
      "serverSide": true,
      "ajax": '{{env("APP_URL")}}dashboard/appointments/dt/all_appointments',
      columns: [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'name', "render": function ( data, type, row ) {
                return row.customer.first_name!=''?row.customer.first_name:'' +' '+ row.customer.last_name!=''?row.customer.last_name:'';
              }
            },
            {data: 'customer.email', name: 'email'},
            {data: 'appointment', name: 'appointment', "render": function ( data, type, row ) {
                return row.appointment_date +' <br/> '+ row.appointment_start_time + ' - ' + row.appointment_end_time;
              }
            },            
            {data: 'action', name: 'action'},
            
        ]
    });
    
  })
</script>

@endpush
@endsection