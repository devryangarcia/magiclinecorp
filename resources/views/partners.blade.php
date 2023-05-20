@extends('admin-dash-layout')
@section('title')
    Admin | Partners
@endsection
@section('page-active')
  Partners
@endsection
@section('links')
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{asset('plugins/ekko-lightbox/ekko-lightbox.css')}}">
  
  <style>
    @media print {
      #unprintable,#example1_paginate,#example1_info,#example1_filter,.dt-buttons,.card-header {
        display: none;
      }
    }
  </style>
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
        <?php $companytrash = DB::table('partners')->where('archived','=',1)->get(); ?>
        <div class="row">
          <div class="col">
            <h3 class="card-title">Partnered Companies</h3>
            <a href="{{route('addcompany')}}" class="btn btn-light ml-3"><i class="fa fa-user-plus"></i> Add New Partner</a>
            <a href="{{route('trashcompany')}}" class="btn btn-light">
              <i class="fas fa-trash"></i> Trash
              <span class="right badge badge-danger">{{count($companytrash)}}</span>
            </a>
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
            <th id="unprintable">Action</th>
          </tr>
          </thead>
          <tbody>
      <?php
        $company = DB::select('select * from partners where archived IS NULL order by company asc');
        foreach ($company as $comp) { ?>
          <tr>
            <td><a href="{{asset('storage/company_logos/'.$comp->logo)}}" data-toggle="lightbox" data-title="{{$comp->company}}" data-gallery="partner">
              <img src="{{asset('storage/company_logos/'.$comp->logo)}}" id="current_logo" alt="<?php echo $comp->logo;?>" style="height: 100px;">
              </a>
            </td>
            <td><?php echo $comp->company; ?></td>
            <td id="unprintable">
              <a href="{{route('updatecomp')}}?id=<?php echo $comp->id; ?>" class="btn btn-light"><i class="fa fa-edit"></i> Edit</a>
              <button type="button" class="btn btn-light" data-toggle="modal" data-target="#myModal<?php echo $comp->id;; ?>">
                <i class="fas fa-trash"></i> Delete
              </button>
            </td>
          </tr>
          <!-- Modal -->
          <div class="modal fade" id="myModal<?php echo $comp->id;; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-m" role="document">
              <div class="modal-content">
                <div class="modal-header bg-warning">
                  <h4 class="modal-title" id="myModalLabel"><i class="icon fas fa-exclamation-triangle"></i> Warning!!</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h4>Are you sure to delete this company?</h4>
                  <form action="{{route('trashcomp')}}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$comp->id}}">
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
              <th id="unprintable">Action</th>
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
<!-- Ekko Lightbox -->
<script src="{{asset('plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
@endsection
