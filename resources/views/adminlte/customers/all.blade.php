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
              <a href="#" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New customer</a>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="business_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Plan</th>
                  <th> {{date('M')}} - Usage</th>
                  <th>Due</th>
                  
                 
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
      "ajax": '{{env("APP_URL")}}dashboard/customers/dt/all_customers',
      "order": [[ 0, "desc" ]],
      columns: [
            {data: 'id', name: 'id'},

            {data: 'name', name: 'name', "render": function ( data, type, row ) {
                return row.first_name!='null'?row.first_name:'' +' '+ row.last_name!='null'?row.last_name:'';
              }
            },
             {data: 'email', name: 'email'},
         
            {data: 'membership', name: 'membership', "render" : function (data, type, row){
                if(row.membership.length > 0)
                  return row.membership[0].plan_name;
              
                return '';

              }
            },
            
            {data: 'usage', name: 'usage', "render": function ( data, type, row ) {
                
              if(row.membership.length>0){
                var html = '';
                if(row.peak_hours_usage.length > 0){
                  html += '<b>Peak Hours:</b> '+ (row.peak_hours_usage[0].peak_hours_used)/60+'/'+ row.membership[0].included_peak_hours +'<br />';
                }
                else if(row.off_peak_hours_usage.length > 0){
                  html += '<b>Off Peak Hours:</b> '+ (row.off_peak_hours_usage[0].off_peak_hours_used)/60+'/'+ row.membership[0].included_off_peak_hours +'<br />';  
                  }
                  return html;
                }
              else{
                if(row.peak_hours_usage.length > 0){
                  // var html = '<b>Peak Hours:</b> '+ row.peak_hours_usage[0].peak_hours_used+'<br />';
                  var html = '<b>Off Peak Hours:</b> '+ (row.off_peak_hours_usage[0].off_peak_hours_used)/60+'<br />';  
                  return html;
                }
              }
              return '';

                // return obj.customer_id;
              }
            },
            // {data: 'due', name: 'due'},
            {data: 'due', name: 'due', "render":function(data, type, row){
              var peak_hour_charge = 60; 
                 var off_peak_hour_charge = 45;
                 var discount_play = 15;  //in percent
                 
                 var used_peak_hours = used_off_peak_hours = 0;

                 if(row.peak_hours_usage.length>0)
                 {
                    used_peak_hours = (row.peak_hours_usage[0].peak_hours_used)/60 
                 }
                if(row.off_peak_hours_usage.length>0){
                    used_off_peak_hours = (row.off_peak_hours_usage[0].off_peak_hours_used)/60; 
                }
                 
                 if(row.membership.length>0){
                  var included_peak_hours = row.membership[0].included_peak_hours;
                  var included_off_peak_hours = row.membership[0].included_off_peak_hours;

                  var sum = ((used_peak_hours - included_peak_hours)*peak_hour_charge) +  ((used_off_peak_hours - included_off_peak_hours)*off_peak_hour_charge);
                  var final = sum - (sum * discount_play)/100;
                 } 
                 else{
                  var final = ((used_peak_hours)*peak_hour_charge) +  ((used_off_peak_hours)*off_peak_hour_charge);
                 }
              
                //  console.log(final);
                 if(final>0)
                  return '$'+final;
                 else
                  return  0; 
             
              return '';
              
              }
            },

          
           
            
           
            {data: 'action', name: 'action'},
            
        ]
    });
    
  })
</script>

@endpush
@endsection