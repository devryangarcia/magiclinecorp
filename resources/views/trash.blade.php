@extends('admin-dash-layout')
@section('title')
  Trash
@endsection
@section('page-back')
<li class="breadcrumb-item"><a href="{{url('admin/users')}}">Users</a></li>
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
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Company</th>
            <th>Role</th>
            <th>Access Lists</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
          $usersList = DB::select('select * from users where archived = 1');
          foreach ($usersList as $userList) { ?>
              <tr>
                <td><img src="{{asset('avatars/'.$userList->avatar)}}" alt="{{$userList->avatar}}" style="height: 75px;"></td>
                  <td><?php echo $userList->fname." ".$userList->lname; ?></td>
                  <td><?php echo $userList->username; ?></td>
                  <td><?php echo $userList->email; ?></td>
                  <td><?php echo $userList->company ?></td>
                  <td><?php if ($userList->role == "admin1") {
                      echo "Admin 1";
                  } elseif ($userList->role == "admin2") {
                      echo "Admin 2";
                  } elseif ($userList->role == "user") {
                      echo "User";
                  }  ?></td>
                  <td>
                    @php
                      $accesslists = DB::select('select * from access_lists where user_id = ?',[$userList->id]);
                      foreach ($accesslists as $access) {
                        foreach(explode(",",$access->accesslists) as $a){
                        echo $a.", ";
                        }
                      }
                    @endphp
                  </td>
                  <td><?php if ($userList->status=='activated') { ?>
                    <span class="badge badge-success"><?php echo $userList->status ?></span>
                  <?php } else { ?>
                    <span class="badge badge-danger"><?php echo $userList->status ?></span>
                  <?php }
                  
                  ?>
                  </td>
                  <td class="d-print-none d-flex">
                    <form action="{{route('restoreuser')}}" method="post">
                      @csrf
                      <input type="hidden" name="id" value="{{$userList->id}}">
                      <button type="submit" class="btn btn-light mr-2"><i class="fa fa-check"></i> Restore</a></button>
                    </form>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#myModal<?php echo $userList->id; ?>">
                      <i class="fas fa-trash"></i> Permanently Delete
                    </button>
                  </td>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal<?php echo $userList->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-m" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-warning">
                          <h4 class="modal-title" id="myModalLabel"><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <h5> Are you sure to delete this product permanently?</h5> 
                          <form action="{{route('userdelete')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{$userList->id}}">
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Permanently Delete</a></button>
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
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Company</th>
            <th>Role</th>
            <th>Access Lists</th>
            <th>Status</th>
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
