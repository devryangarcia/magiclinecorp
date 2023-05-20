@extends('dash-layout')
<?php
  $comp = ucwords($_GET['comp']);
  $categ = $_GET['categ'];
  $type = ucwords($_GET['type']);
  if($categ=='busttorso'){
    $choice = 'Bust and Torso';
  } else {
    $choice = $categ;
  }
?>
@section('title')
    {{ucwords($comp)}}
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
        <h3 class="card-title"><?php echo $comp.' | '.$choice.' | '.$type;?> </h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Image</th>
            <th>Purchase Order</th>
            <th>Reference Name</th>
            <th>Company</th>
            <th>Information</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <?php
              $products = DB::table('products')
              ->where('company', 'like', '$comp')
              ->where('category', 'like', '$choice')
              ->where('type', '=', '$type')
              ->get();
              foreach($products as $product){ 
                $delimiter = ",";
                $image_array = explode($delimiter, $product->images);
                $first_image = $image_array[0];
                ?>
              
            <td><img src="{{asset('storage/product_images/'.$first_image)}}" alt="<?php echo $product->images;?>" style="height: 100px"></td>
            <td><?php echo $product->po; ?></td>
            <td><?php echo $product->refname; ?></td>
            <td><?php echo $product->company; ?></td>
            <td><?php echo $product->information; ?></td>
            <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-xl">
              View Info
            </button></td>
            <div class="modal fade" id="modal-xl">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title"><?php echo $product->refname; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      <div class="row">
                          <div class="col-6">
                              <div class="row">
                                  <div class="col">
                                    @foreach(explode(',', $product->images) as $image)
                                        <img src="{{ asset('storage/product_images/'.$image) }}" alt="<?php echo $image; ?>" class="mt-2" style="height: 300px; width: 250px;">
                                    @endforeach
                                  </div>
                              </div>
                          </div>
                          <div class="col-6">
                              <p><b>Purchase Order:</b> <?php echo $product->po; ?></p>
                              <p><b>Reference Name:</b> <?php echo $product->refname; ?></p>
                              <p><b>Company:</b> <?php echo $product->company; ?></p>
                              <p><b>Information:</b> <?php echo $product->information; ?></p>
                          </div>
                      </div>
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </tr>
          </tbody>
          <tfoot>
          <tr>
              <th>Image</th>
              <th>Purchase Order</th>
              <th>Reference Name</th>
              <th>Company</th>
              <th>Information</th>
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
<!-- Page specific script -->
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
