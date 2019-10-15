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
              <h3 class="box-title">Configuration</h3>
              @if($customer_type==1)
              <a href="{{url('/dashboard/locations/load_config/')}}/{{$location_code}}" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Edit Config</a>  
              @endif
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="config_table" class="table table-bordered ">
                <thead>
                <tr>
                  
                  <th>Key</th>
                  <th>Value</th>
                </tr>
                </thead>
                <tbody>
                  @php
                    $i=0;
                  @endphp
                  @foreach($all_config as $k=>$c)
                  <tr>
                   
                    <td>
                      
                        {{$c->config_key}} 
                    </td>
                    <td>
                   
                      {{$c->config_value}} 
                    

                    </td>
                  </tr>
                  @php
                    $i++;
                  @endphp
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
    $('#config_table').DataTable({
      "processing": true,
      "serverSide": false,
      "ordering": false
      "paging":   false,
    });
  })
</script>

@endpush
@endsection