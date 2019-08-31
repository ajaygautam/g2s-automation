@extends('adminlte.layouts.app')

@section('content')

@push('styles')
     <!-- DataTables -->
 <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  
@endpush

  <form name='config_form' action="/dashboard/config" method="post">
  @csrf

   <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Configuration</h3>
              <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Save Configruation</button>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="config_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
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
                    <td>{{$c->id}}</td>
                    <td>
                       <input type="hidden" name="data[{{$i}}][id]" value="{{$c->id}}" /> 
                       <!-- <input name="data[{{$k}}][config_key]" value="{{$c->config_key}}" />  -->
                       {{$c->config_key}} 
                    </td>
                    <td>
                        <input name="data[{{$i}}][config_value]" value="{{$c->config_value}}" /> 
                        <span style="display:none">{{$c->config_value}}</span>   
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
  </form>


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
      
      "paging":   false,
    });
  })
</script>

@endpush
@endsection