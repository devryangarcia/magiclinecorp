@extends('admin-dash-layout')
@section('title')
    Admin | Trash
@endsection
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/partners/')}}">Partners</a></li>
@endsection
@section('page-active')
    Trash
@endsection
@section('links')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('main-content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        @if(Session::get('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-check"></i> {{ Session::get('success') }}
        </div>
        @endif
        @if(Session::get('deleted'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <i class="icon fas fa-ban"></i>  {{ Session::get('deleted') }}
        </div>
        @endif
        <div class="row">
          <div class="col-md-1">
            <h3 class="card-title">Trash</h3>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Logo</th>
            <th>Company</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
          $companylists = DB::select('select * from partners where archived = 1');
          foreach ($companylists as $companylist) { ?>
              <tr>
                  <td><img src="{{asset('storage/company_logos/'.$companylist->logo)}}" id="current_logo" alt="<?php echo $companylist->logo;?>" style="height: 100px;"></td>
                  <td><?php echo $companylist->company; ?></td>
                  <td class="d-print-none d-flex">
                    <form action="{{route('restorecomp')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$companylist->id}}">
                        <button type="submit" class="btn btn-light"><i class="fa fa-check"></i> Restore</button>
                    </form>
                    <button type="button" class="btn btn-light ml-2" data-toggle="modal" data-target="#myModal<?php echo $companylist->id;; ?>">
                      <i class="fas fa-trash"></i> Permanently Delete
                    </button>
                  </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="myModal<?php echo $companylist->id;; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-warning">
                        <h4 class="modal-title" id="myModalLabel"><i class="icon fas fa-exclamation-triangle"></i> Warning!!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h4>Are you sure to delete this permanently?</h4>
                        <form action="{{route('deletecomp')}}" method="post">
                          @csrf
                          <input type="hidden" name="id" value="{{$companylist->id}}">
                          <button type="submit"class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
      <?php } ?>
          
          
          </tbody>
          <tfoot>
          <tr>
            <th>Logo</th>
            <th>Company</th>
              <th>Action</th>
          </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
</div>
@endsection
@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
</script>
@endsection
