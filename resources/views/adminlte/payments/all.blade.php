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
              <h3 class="box-title">All Payments</h3>
              <a href="#" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New payment</a>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="business_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>Stripe Data</th>
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
      "ajax": '{{env("APP_URL")}}dashboard/payments/dt/all_payments',
      "order": [[ 0, "desc" ]],
      columns: [
            {data: 'id', name: 'id'},
            {data: 'stripe_customer_id', name: 'stripe_customer_id'},
            {data: 'amount', name: 'amount'},
            {data: 'stripe_payment_created', name: 'stripe_payment_created'},
            
            {data: 'stripe_data', name: 'stripe_data', "render": function ( data, type, row ) {
                var html = '<b>Charge ID:</b> '+ row.stripe_charge_id +'<br />';
                html += '<b>Transaction ID:</b> '+ row.stripe_balance_transaction +'<br />';
                html += '<b>Invoice:</b> '+ row.stripe_invoice +'<br />';
                html += '<b>CC:</b> xxxx xxxx xxxx '+ row.stripe_card_last_4;
                // return '<b>Charge ID:</b> '+ row.stripe_charge_id;
                return html;
              }
            },
  
            {data: 'action', name: 'action'},
            
        ]
    });
    
  })
</script>

@endpush
@endsection