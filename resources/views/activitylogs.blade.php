@extends('admin-dash-layout')
@section('title')
  Activity Logs
@endsection
@section('page-active')
  Activity Logs
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
          $user_requests = DB::select('select * from reset_requests');
        @endphp
        <div class="row">
          <div class="col-md-1">
            <h3 class="card-title">Activity Logs</h3>
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
            <th>Company</th>
            <th>Role</th>
            <th>Activity</th>
            <th>Date</th>
            <th>Time</th>
          </tr>
          </thead>
          <tbody>
      <?php
        $activitylogs = DB::select('select * from activity_logs order by timestamp desc');
          foreach ($activitylogs as $activitylog) { 
          $usersLists = DB::select('select * from users where id = ?',[$activitylog->user_id]);
          foreach ($usersLists as $userList) {
            ?>
              <tr>
                <td><img src="{{asset('avatars/'.$userList->avatar)}}" alt="{{$userList->avatar}}" style="height: 75px;"></td>
                <td><?php echo $userList->fname." ".$userList->lname; ?></td>
                <td><?php echo $userList->company ?></td>
                <td><?php if ($userList->role == "admin1") {
                    echo "Admin 1";
                } elseif ($userList->role == "admin2") {
                    echo "Admin 2";
                } elseif ($userList->role == "owner") {
                    echo "Owner";
                } elseif ($userList->role == "user") {
                    echo "User";
                }  ?></td>
                <td>{{$activitylog->activity}}</td>
                <td>{{ date("M-d-y", strtotime($activitylog->timestamp))}}</td>
                <td>{{ date("H:i:s", strtotime($activitylog->timestamp))}}</td>
              </tr>
              
      <?php } } ?>
          
          
          </tbody>
          <tfoot>
          <tr>
            <th>Avatar</th>
            <th>Full Name</th>
            <th>Company</th>
            <th>Role</th>
            <th>Activity</th>
            <th>Date</th>
            <th>Time</th>
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
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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
