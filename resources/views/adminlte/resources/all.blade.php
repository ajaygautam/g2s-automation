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
              <h3 class="box-title">All Resource</h3>
              <a href="{{url('/dashboard/resources/create')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> New Resource Plan</a>  
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="resource_table" class="table table-bordered ">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Peak Hours Cost</th>
                  <th>Off Peak Hours Cost</th>
                  <th>Actions</th>
                </tr>
                </thead>
                
                <tbody>
                  @foreach($allResources as $resource)
                  <tr>
                    <td>{{$resource->id}}</td>
                    <td>{{$resource->resource_name}}</td>
                    <td>{{$resource->resource_type==1?'Bay':''}}</td>
                    <td>{{$resource->peak_price}}</td>
                    <td>{{$resource->off_peak_price}}</td>
                    <td>
                      <a href="/dashboard/resources/{{$resource->id}}/edit"><i class="fa fa-pencil"></i></a>
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
    $('#resource_table').DataTable({
      "processing": true,
      "serverSide": false,
      "paging": false,
      "order": [[ 0, "desc" ]],
    });
    
  })
</script>

@endpush
@endsection