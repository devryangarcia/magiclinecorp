@extends('admin-dash-layout')
@section('title')
Admin | Users
@endsection
@section('page-active')
Users
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
        @php
            $userequests = DB::select('select * from reset_requests');
            $usertrash = DB::select('select * from users where archived = 1');
        @endphp
        <h3 class="card-title">Users</h3>
        <a href="{{route('adduser')}}" class="btn btn-light ml-2"><i class="fas fa-user-plus"></i><span class="ml-2">Add User</span></a>
        <a href="{{route('trash')}}" class="btn btn-light ml-2">
          <i class="fas fa-trash"></i><span class="ml-2">Trash</span>
          <span class="right badge badge-danger">{{count($usertrash)}}</span>
        </a>
        <a href="{{route('userrequest')}}" class="btn btn-light ml-2">
          <i class="fas fa-user"></i>
          <span class="ml-2">Reset Password Request</span>
          <span class="right badge badge-danger">{{count($userequests)}}</span>
        </a>
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
            <th class="col-md-3 col-sm-12 col-12">Access List</th>
            <th class="col-md-1 col-sm-12 col-12">Status</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
        $users = DB::table('users')->whereNull('archived')->get();
        foreach ($users as $user) {
        
        $accesslists = DB::table('access_lists')->where('user_id','=',$user->id)->get();
        foreach ($accesslists as $accesslist) {
          $lists = $accesslist->accesslists;
        }
        ?>
        <tr>
          <td><img src="{{asset('avatars/'.$user->avatar)}}" alt="<?php echo $user->avatar;?>" style="height: 70px"></td>
          <td><?php echo $user->fname.' '.$user->lname; ?></td>
          <td><?php echo $user->username; ?></td>
          <td><?php echo $user->email; ?></td>
          <td><?php echo $user->company; ?></td>
          @if ($user->role=='admin1')
           <td>Admin 1</td>
          @elseif ($user->role=='admin2')
          <td>Admin 2</td>
          @elseif ($user->role=='owner')
          <td>Owner</td>
          @elseif ($user->role=='user')
          <td>User</td>
          @endif
          <?php ?>
          <td><?php echo $lists; ?></td>
          <td><?php echo $user->status; ?></td>
          <td>
            <a href="{{route('user',$user->id)}}" class="btn btn-light"><i class="fa fa-edit"></i> Edit</a>
            @if ($user->role!='owner')
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#myModal<?php echo $user->id; ?>" >
              <i class="fas fa-trash"></i> Delete
            </button>     
            @endif
            
          </td>
        </tr>
  
        <!-- Modal -->
        <div class="modal fade" id="myModal<?php echo $user->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
              <div class="modal-header bg-warning">
                <h4 class="modal-title" id="myModalLabel"><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <h5> Are you sure to delete this product?</h5>
                <form action="{{route('trashuser')}}" method="post">
                  @csrf
                  <input type="hidden" name="id" value="{{$user->id}}">
                  <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i>  Delete</button>
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
            <th class="col-md-3 col-sm-12 col-12">Access List</th>
            <th class="col-md-1 col-sm-12 col-12">Status</th>
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
