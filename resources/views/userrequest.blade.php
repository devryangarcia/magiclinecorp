@extends('admin-dash-layout')
@section('title')
Reset Password Request
@endsection
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/users')}}">Users</a></li>
@endsection
@section('page-active')
Reset Password Request
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
        <h3 class="card-title">Reset Password Request</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Company</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
        $requestLists = DB::select('select * from reset_requests');
          
          foreach ($requestLists as $requestList) {
            $userLists = DB::select('select * from users where id = ?',[$requestList->user_id]);
            foreach($userLists as $userList)
          { ?>
              <tr>
                  <td><img src="{{asset('avatars/'.$userList->avatar)}}" alt="{{$userList->avatar}}" style="height: 75px;"></td>
                  <td><?php echo $userList->fname." ".$userList->lname; ?></td>
                  <td><?php echo $userList->username; ?></td>
                  <td><?php echo $userList->email; ?></td>
                  <td><?php echo $userList->company ?></td>
                  <td class="d-print-none" colspan="3">
                    <div class="d-flex flex-row">
                        <form action="{{route('grantrequest')}}" method="post">
                            @csrf
                            <input type="hidden" name="uid" value="<?php echo $userList->id; ?>">
                            <button type="submit" class="btn btn-light"><i class="fa fa-check"></i> Approve</button>
                        </form>
                        <button type="button" class="btn btn-light ml-2" data-toggle="modal" data-target="#myModal<?php echo $userList->id; ?>">
                            <i class="fas fa-times"></i> Delete
                        </button>
                    </div>
                  </td>
          
                <!-- Modal -->
                <div class="modal fade" id="myModal<?php echo $userList->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Warning!!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h4>Are you sure to delete to delete this request?
                        <form action="{{route('removerequest')}}" method="post">
                            @csrf
                            <input type="hidden" name="uid" value="<?php echo $userList->id; ?>">
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                  </td>
                </tr>
      <?php }} ?>
          
          
          </tbody>
          <tfoot>
          <tr>
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
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
